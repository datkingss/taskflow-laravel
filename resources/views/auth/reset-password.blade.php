<x-guest-layout>
    <h4 class="text-center fw-bold mb-4 text-dark">Đặt lại mật khẩu</h4>

    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Địa chỉ Email</label>
            <input id="email" type="email" name="email" class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Mật khẩu mới</label>
            <input id="password" type="password" name="password" class="form-control py-2 @error('password') is-invalid @enderror" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Xác nhận mật khẩu</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control py-2 @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
            Đặt lại mật khẩu
        </button>
    </form>
</x-guest-layout>
