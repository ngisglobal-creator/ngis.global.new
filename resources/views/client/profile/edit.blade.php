@extends('client.layouts.master')

@section('title', __('dashboard.profile'))

@section('content')
<section class="content-header">
  <h1>{{ __('dashboard.profile') }}</h1>
</section>

<section class="content">
  @include('profile.partials.edit-form')
</section>
@endsection
