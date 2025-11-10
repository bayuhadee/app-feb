{{-- <div style="display: flex; align-items: center; width: 100%;">
  <hr style="flex-grow: 1; border: none; border-top: 1px solid #ccc;">
  <span style="margin: 0 0.75rem; color: #6b7280; font-size: 0.875rem;">or</span>
  <hr style="flex-grow: 1; border: none; border-top: 1px solid #ccc;">
</div> --}}

<x-filament::button :href="route('socialite.redirect', 'google')" tag="a" color="gray" outlined="true">
  <x-slot:icon>
    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" style="width: 20px; height: 20px;">
  </x-slot:icon>

  Sign in with Google
</x-filament::button>
