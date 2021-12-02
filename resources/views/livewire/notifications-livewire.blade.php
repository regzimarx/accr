<div class="mt-16">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                File Requests
            </h2>
        </div>
    </header>

    <div class="max-w-screen-2xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col">
            <div class="-my-2 border-1 border-gray-500 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 sm:rounded-sm">


                        <table class="table-auto w-full border-1 border-blue-500 md:border-blue-500 ">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                        From</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        File title</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        File</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        Designation</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                        Access code</th>
                                    <th
                                        class="px-6 py-3 bg-gray-200 text-left text-l leading-4 text-black-500 font-size text-xs tracking-wider">
                                        @if (Auth::user()->role->code == 'hr')
                                            Actions
                                        @else
                                            Status
                                        @endif
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 ">
                                @if ($data->count())
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->name }}</td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->role_title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->file_name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                {{ $item->designation_title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->access_code }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm flex gap-1">
                                                @if (Auth::user()->role->code == 'hrdo')
                                                    <x-jet-button
                                                        wire:click="generateAccessCode({{ $item->id }}, {{ $item->doc_id }})"
                                                        class="px-1 py-1 bg-green-500 rounded-full"
                                                        title="Accept and generate access code">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </x-jet-button>
                                                    <x-jet-button
                                                        wire:click="denyRequest({{ $item->id }}, {{ $item->doc_id }})"
                                                        class="px-1 py-1 bg-red-500 rounded-full" title="Deny request">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </x-jet-button>
                                                @else
                                                    @if ($item->accepted == true)
                                                        Granted
                                                    @elseif ($item->accepted == false)
                                                        Denied
                                                    @else
                                                        Pending
                                                    @endif
                                                @endif

                                                {{-- <x-jet-button wire:click="downloadFile('{{ $item->file }}')"
                                                class="px-2 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </x-jet-button>
                                            <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})"
                                                class="px-2 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                </x-jet-button>
                                                <x-jet-button wire:click="generateAccessCode({{ $item->id }})"
                                                    class="px-2 py-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                    </svg>
                                                </x-jet-button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan="7">
                                            No requests</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
