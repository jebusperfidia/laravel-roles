{{-- <div>
    <h2>Hola soy los completados</h2>
</div>
 --}}

 <div>
    {{-- <flux:heading size="xl" level="1">{{ __('Usuarios') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Administra tus usuarios') }}</flux:subheading>
    <flux:separator variant="subtle" /> --}}

    <div>
          <div class="p-3">
              <h1 class="text-2xl font-bold mb-4">Completados</h1>
            {{--   <button class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                  Create
              </button> --}}
              <div class="overflow-x-auto mt-4">
                  <table class="w-full text-sm text-left text-gray-700">
                      <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                      <tr>
                          <th scope="col" class="px-6 py-3">ID</th>
                          <th scope="col" class="px-6 py-3">Title</th>
                          <th scope="col" class="px-6 py-3">Body</th>
                          <th scope="col" class="px-6 py-3 w-70">Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                          <td class="px-6 py-2 font-medium text-gray-900">ID</td>
                          <td class="px-6 py-2 text-gray-700">Title</td>
                          <td class="px-6 py-2 text-gray-700">Body</td>
                          <td class="px-6 py-2 space-x-1">
                              <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                  Edit
                              </button>
                              <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                  Show
                              </button>
                              <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                  Delete
                              </button>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
</div>
