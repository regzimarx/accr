<div class="mt-16">
    <header class="bg-white">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-medium text-lg text-gray-800 leading-tight text-center">
                Dashboard | Administrator | List of Users
            </h2>
        </div>
    </header>

    <div class="max-w-7xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 border-1 border-gray-500 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-300 rounded-lg drop-shadow-sm">
                        <table class="table-auto w-full border-1 border-blue-500 md:border-blue-500 rounded-lg">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        Department</th>
                                    <th
                                        class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500 font-size text-xs tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 ">
                                @if ($data->count())
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap font-light">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap font-light">
                                                {{ $item->email }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                {{ $item->role->role_title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                {{ $item->dept->dept_name }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm flex gap-1">

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan="5">No
                                            users yet</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="mt-5 mb-10">
                {{ $data->links() }}
            </div>
        </div>
    </div>

</div>
