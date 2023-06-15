<?php

namespace Tests\Unit;

use Tests\TestCase;

class FormSubmissionTest extends TestCase {

    public function testFormValidationRequiredFields() {
        $response = $this->post('/store-form', []);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['company_symbol', 'start_date', 'end_date', 'email']);
    }

    /**
     * Test form validation for Valid Company Symbol.
     *
     * @return void
     */
    public function testValidCompanySymbol() {
        $data = [
            'company_symbol' => 'ALZ',  // Invalid company symbol
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-01',
            'email' => 'summiya.rasheed@gmail.com'
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['company_symbol']);
    }

    /**
     * Test form validation for valid email format.
     *
     * @return void
     */
    public function testFormValidationEmailFormat() {
        $data = [
            'company_symbol' => 'AAIT',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-15',
            'email' => 'invalid-email' // Invalid email format
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * Test form validation for date format.
     *
     * @return void
     */
    public function testFormValidationWrongDateFormat() {
        $data = [
            'company_symbol' => 'AAL',
            'start_date' => '2023-06-01',
            'end_date' => '2023/06/15',
            'email' => 'invalid-email' // Invalid email format
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    }


    /**
     * Test form validation for start date less than End Date.
     *
     * @return void
     */
    public function testFormValidationStartDateIsGreaterThenEndDate() {
        $data = [
            'company_symbol' => 'AAL',
            'start_date' => '2023-06-06', // start date is greater than end date
            'end_date' => '2023-06-05',
            'email' => 'summiya.rasheed@gmail.com'
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['start_date']);
    }

    /**
     * Test form validation Required Dates
     *
     * @return void
     */
    public function testFormValidationRequiredDate() {
        $data = [
            'company_symbol' => 'AAL',
            'start_date' => '2023-06-06',
            'end_date' => '', // missing end date
            'email' => 'summiya.rasheed@gmail.com'
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['end_date']);
    }

    /**
     * Test form for Valid Input
     *
     * @return void
     */
    public function testFormValidationValidForm() {
        $data = [
            'company_symbol' => 'AAME',
            'start_date' => '2023-06-06',
            'end_date' => '2023-06-08',
            'email' => 'summiya.rasheed@gmail.com'
        ];

        $response = $this->post('/store-form', $data);

        $response->assertStatus(302)
            ->assertSessionHas('company_symbol')
            ->assertSessionHas('status');
    }

}


