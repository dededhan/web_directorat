@if(auth()->user()->role === 'prodi')
    @extends('prodis.index')
    @section('contentprodis')
        @include('account.partials.form')
    @endsection
@elseif(auth()->user()->role === 'fakultas')
    @extends('fakultas.index')
    @section('contentfakultas')
        @include('account.partials.form')
    @endsection
@endif
