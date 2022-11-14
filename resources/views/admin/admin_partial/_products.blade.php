<table class="table table-hover text-nowrap table-bordered" id="products">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th width="3%">المنتج</th>
            <th width="3%">السعر</th>
            <th width="3%">الصورة</th>
            <th width="3%">الصنف</th>
            <th width="3%">تاريخ </th>
        </tr>
    </thead>
    <tbody>
        @if ($products->count() > 0)
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->image }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->created_at->format('l d-m-y') }}</td>
                </tr>
            @endforeach
        @endif
    <tbody>
</table>