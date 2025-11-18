<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex items-center px-4 py-2 bg-blue-200 rounded-md font-semibold text-xl text-skyblue-850 uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
