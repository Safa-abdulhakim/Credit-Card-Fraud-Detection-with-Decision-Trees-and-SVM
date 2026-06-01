@extends('layouts.app')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@section('title', ($isAr ? 'بحث: ' : 'Search: ').$query)
@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-4">{{ $isAr ? 'نتائج البحث عن:' : 'Search results for:' }} <span class="text-primary">"{{ $query }}"</span> <small class="text-muted fs-6">({{ $products->total() }} {{ $isAr ? 'نتيجة' : 'found' }})</small></h4>
    @if($products->isEmpty())
        <div class="text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3 d-block"></i><h5>{{ $isAr ? 'لا توجد نتائج لـ' : 'Nothing found for' }} "{{ $query }}"</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">{{ $isAr ? 'تصفح جميع المنتجات' : 'Browse All Products' }}</a></div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$product])</div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    @endif
</div>
@endsection
