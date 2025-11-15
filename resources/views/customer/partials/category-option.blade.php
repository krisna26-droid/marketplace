<option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
    {{ $prefix . $category->name }}
</option>

@if ($category->children && $category->children->count())
    @foreach ($category->children as $child)
        @include('customer.partials.category-option', ['category' => $child, 'prefix' => $prefix . '— '])
    @endforeach
@endif
    