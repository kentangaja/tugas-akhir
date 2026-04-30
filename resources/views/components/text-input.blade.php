@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#d4e9d4] focus:ring-[#063b2a] rounded-md shadow-sm']) }}>
