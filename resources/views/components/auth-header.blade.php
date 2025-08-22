@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading  class="custom-flux-heading">{{ $title }}</flux:heading>
    <flux:subheading class="custom-flux-subheading">{{ $description }}</flux:subheading>
  {{--   <flux:heading size="xl" class="text-black">{{ $title }}</flux:heading>
    <flux:subheading class="text-black">{{ $description }}</flux:subheading> --}}
</div>
