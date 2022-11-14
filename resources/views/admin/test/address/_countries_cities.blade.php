<div class="col-md-3">
    <div class="form-group">
        <label>Country:</label>
        <div class="input-icon input-icon-right">
            <select name="country_id" id="selectCountryCheckout" class="form-control">
                @foreach (\App\Models\Country::all() as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>City:</label>
        <div class="input-icon input-icon-right">
            <select name="city_id" id="selectCityCheckout" class="form-control">

                <option value="">Please Choose City</option>
            </select>
        </div>
    </div>
</div>