<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden w-full max-w-4xl">

        <div class="md:w-1/2 bg-indigo-600 text-white flex items-center justify-center p-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">CourtEase</h1>
            </div>
        </div>


        <div class="md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Reset Password</h2>

            @if ($errors->any() && !$errors->has('password') && !$errors->has('password_confirmation'))
                <div class="mb-4 text-red-600 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ request()->token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <p class="mt-1 text-gray-900 font-semibold">{{ $email ?? 'N/A' }}</p>
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        required 
                        class="mt-1 block w-full rounded-lg border @error('password') border-red-500 @else border-gray-300 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        required 
                        class="mt-1 block w-full rounded-lg border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-200"
                    >
                        Reset Password
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ url()->previous() }}" class="text-indigo-600 hover:underline"> Back</a>
            </div>
        </div>
    </div>

</body>
</html>
