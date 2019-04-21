@extends('layouts.app')

@section('content')
<div class="flex flex-col">

    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div>
                <h1 class="text-grey-darker text-center font-thin tracking-wide text-5xl mb-6">
                    {{ config('app.name', 'Laravel') }}
                </h1>
            </div>
        </div>
    </div>
</div>
@endsection

