<div id="content-table">
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Open</th>
            <th scope="col">High</th>
            <th scope="col">Low</th>
            <th scope="col">Close</th>
            <th scope="col">Volume</th>

        </tr>
        </thead>
        <tbody>
        @foreach($historical_data as $data)
            <tr>
                <td>@isset($data->date) {{ $data->date }} @endisset </td>
                <td>@isset($data->open) {{ $data->open }} @endisset</td>
                <td>@isset($data->high) {{ $data->high }} @endisset</th>
                <td>@isset($data->low) {{ $data->low }} @endisset</td>
                <td>@isset($data->close) {{ $data->close }} @endisset</td>
                <td>@isset($data->volume) {{ $data->volume }} @endisset</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Open</th>
            <th scope="col">High</th>
            <th scope="col">Low</th>
            <th scope="col">Close</th>
            <th scope="col">Volume</th>
        </tr>
        </tfoot>
    </table>
</div>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $('#example').DataTable({
        pagingType: 'full_numbers',
    });

</script>
