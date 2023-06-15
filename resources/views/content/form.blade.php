<div id="content-form">
    <div class="card-header text-center font-weight-bold">
        Please Fill this form
    </div>
    <div class="card-body">
        <form name="add-post-form" id="add-post-form" method="post" action="{{url('store-form')}}">
            @csrf
            <div class="form-group">
                <label for="exampleCompanySymbol">Company Symbol</label>
                <select id="select-state" name="company_symbol">
                    @foreach ($data as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('company_symbol')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputStartDate">Start Date</label>
                <input type="text" id="start_date" name="start_date" class="form-control" required=""
                       value="{{ old('start_date') }}">
                <small id="exampleInputStartDate" class="form-text text-muted">Start Date should be less then or Equal
                    to Today
                    or End Date </small>
                @error('start_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEndDate">End Date</label>
                <input type="text" id="end_date" name="end_date" class="form-control" required=""
                       value="{{ old('end_date') }}">
                <small id="exampleInputEndDate" class="form-text text-muted">End Date should be greater then or Equal to
                    Today
                    or Start Date </small>
                @error('end_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <p id="date_error" style="color: red; display: none;">End Date should be greater then or Equal to today
                    or Start Date.</p>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Email</label>
                <input type="email" id="email" name="email" class="form-control" required=""
                       value="{{ old('email') }}">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
