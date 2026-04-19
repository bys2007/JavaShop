@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')
@section('content')
    <section class="py-8">
        <div class="container-main">
            <div class="grid lg:grid-cols-4 gap-8">
                @include('components.account-sidebar')

                <div class="lg:col-span-3">
                    <h1 class="font-display font-semibold text-h1 text-on-surface mb-6">Ubah Kata Sandi</h1>

                    <div class="card p-6 max-w-lg">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="form-label">KATA SANDI LAMA</label>
                                <input id="current_password" type="password" name="current_password" class="form-input" required>
                                @error('current_password') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password" class="form-label">KATA SANDI BARU</label>
                                <input id="password" type="password" name="password" class="form-input" required>
                                @error('password') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="form-label">KONFIRMASI KATA SANDI</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required>
                            </div>

                            <button type="submit" class="btn-primary">Ubah Kata Sandi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
