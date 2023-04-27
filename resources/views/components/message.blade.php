@if (Session::has('success') || Session::has('error'))
    <div class="pt-12" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-2 bg-white shadow sm:rounded-lg">
                <div>
                    @if (Session::has('success'))
                        <div class="text-center font-semibold" style="color: green;">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="text-center font-semibold" style="color: red;">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
