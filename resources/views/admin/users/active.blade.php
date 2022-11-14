@if ($users->active == 1)
    <span class="badge badge-primary">فعال</span>
    @else
    <span class="badge badge-danger">غير فعال</span>
@endif