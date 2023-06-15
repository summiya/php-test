<?php

namespace App\Http\Controllers;

use App\Libraries\Notification\NotificationService;
use App\Services\CompanySymbolService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormController extends Controller {

    private CompanySymbolService $companySymbolService;
    private NotificationService $notificationService;

    public function __construct(CompanySymbolService $companySymbolService, NotificationService $notificationService) {
        $this->companySymbolService = $companySymbolService;
        $this->notificationService = $notificationService;
    }

    public function index() {

        $companySymbols = $this->companySymbolService->getCompanySymbols();

        // if session is available then find historical data and show it
        if (session('company_symbol')) {

            $companySymbol = session('company_symbol');

            $historicalData = $this->getHistoricalData($companySymbol);

            return view('main', [
                'data' => $companySymbols,
                'historical_data' => $historicalData['transformedHistoricalData']->prices,
                'labels' => $historicalData['labels'],
                'openPrices' => $historicalData['open_prices'],
                'closePrices' => $historicalData['close_prices']
            ]);

        }

        return view('main', [
            'data' => $companySymbols
        ]);
    }

    public function store(Request $request) {

        $this->validation($request);
        $this->sendEmail($request);

        return redirect('/')
            ->with(
                [
                    'status' => 'Form is submitted Successfully',
                    'company_symbol' => $request->get('company_symbol')
                ]);
    }

    private function getHistoricalData(string $companySymbol): ?array {
        return $this->companySymbolService->getHistoricalData($companySymbol);
    }

    private function validation(Request $request) {

        // get company symbols and validate the input
        $companySymbols = $this->companySymbolService->getCompanySymbols();

        $request->validate([
            'company_symbol' => [
                'required',
                'in:' . implode(',', $companySymbols)
            ],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'email' => 'required|email'
        ]);

    }

    private function sendEmail(Request $request) {
        $companyName = $this->companySymbolService->getCompanyName($request->get('company_symbol'));
        $request->request->add(['company_name' => $companyName]);
        $this->notificationService->sendEmail($request->request);
    }

}
