<div class="col-md-3">
    <div class="form-group">
        <label>Country:</label>
        <div class="input-icon input-icon-right">
            <select name="country_en_id" id="selectCountry_en_Checkout" class="form-control">
                @foreach (\App\Models\Country_en::all() as $country)
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
            <select name="city_en_id" id="selectCity_en_Checkout" class="form-control">

                <option value="">Please Choose City</option>
            </select>
        </div>
    </div>
</div>