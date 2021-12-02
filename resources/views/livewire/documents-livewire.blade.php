 <div class="mt-16">

     <header class="bg-white">
         <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
             <h2 class="font-medium text-lg text-gray-800 leading-tight text-center">
                 @if ($desig == null)
                     Dashboard | {{ Auth::user()->role->role_title }} |
                     {{ Auth::user()->dept->dept_name }}
                 @else
                     {{ $desig->designation_title }} | {{ Auth::user()->role->role_title }} |
                     {{ Auth::user()->dept->dept_name }}
                 @endif
             </h2>
         </div>
     </header>

     <div class="max-w-7xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
         @if ($desig != null)
             @if ($desig->code == 'dc' && Auth::user()->role->code == 'dean')
                 <div class="flex items-center justify-start py-3 text-right my-5">
                     <x-jet-input id="accessCode" class="block mt-1 w-1/2 text-sm" type="text"
                         wire:model.debounce.800ms="accessCode"
                         placeholder="Please enter access code to view or download file" />
                 </div>
             @else
                 <div class="flex items-center justify-end py-3 text-right my-5">
                     <x-jet-button type="button" wire:click.prevent="createShowModal"
                         class="px-2 py-3 ml-5 rounded-lg capitalize font-light">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                             fill="currentColor">
                             <path fill-rule="evenodd"
                                 d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                 clip-rule="evenodd" />
                         </svg> &nbsp;Upload file
                     </x-jet-button>
                 </div>
             @endif
         @endif

         @if ($desig == null)
             <div class="flex flex-col">
                 <div class="-my-2 border-1 border-gray-500 overflow-x-auto sm:-mx-6 lg:-mx-8">
                     <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                         <div class="overflow-hidde sm:rounded-sm">
                             <h2 class="font-medium text-xl">Welcome back {{ Auth::user()->name }}!</h2>
                         </div>
                     </div>
                 </div>
             </div>
         @else
             <div class="flex flex-col">
                 <div class="-my-2 border-1 border-gray-500 overflow-x-auto sm:-mx-6 lg:-mx-8">
                     <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                         <div class="overflow-hidden border border-gray-300 rounded-lg drop-shadow-sm">
                             <table class="table-auto w-full border-1 border-blue-500 md:border-blue-500 rounded-lg">
                                 <thead>
                                     <tr>
                                         <th
                                             class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                             Title</th>
                                         <th
                                             class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500 text-xs tracking-wider">
                                             Description</th>
                                         <th
                                             class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                             File</th>
                                         <th
                                             class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                             Designation</th>
                                         <th
                                             class="px-6 py-3 bg-white text-left text-l leading-4 text-black-500  text-xs tracking-wider">
                                             Uploaded by</th>
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
                                                     {{ $item->title }}
                                                 </td>
                                                 <td class="px-6 py-4 text-sm whitespace-no-wrap font-light">
                                                     {{ $item->description }}
                                                 </td>
                                                 <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                     {{ $item->file_name }}
                                                 </td>
                                                 <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                     {{ $item->designation->designation_title }}
                                                 </td>
                                                 <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                     {{ $item->name }}
                                                 </td>
                                                 <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                     {{ $item->dept_name }}
                                                 </td>
                                                 <td class="px-6 py-4 text-right text-sm flex gap-1">
                                                     @php
                                                         $access_all_uploaded_files = ['accr_co', 'accr'];
                                                     @endphp
                                                     @if ($desig->code == 'dc' && Auth::user()->role->code == 'dean')
                                                         @if ($accessCode == $item->access_code && $accessCode != null)
                                                             <x-jet-button
                                                                 wire:click="downloadFile('{{ $item->file_name }}')"
                                                                 class="px-1 py-1 rounded-full bg-blue-200 hover:bg-blue-300 active:hover:bg-blue-300 text-blue-900">
                                                                 <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="h-4 w-4" viewBox="0 0 20 20"
                                                                     fill="currentColor">
                                                                     <path fill-rule="evenodd"
                                                                         d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                                                         clip-rule="evenodd" />
                                                                 </svg>
                                                             </x-jet-button>
                                                         @else
                                                             <x-jet-button
                                                                 wire:click="requestFile('{{ $item->id }}')"
                                                                 class="px-1 py-1 bg-blue-200 hover:bg-blue-300 active:hover:bg-blue-300 text-blue-900 rounded-full shadow-2xl"
                                                                 title="Send request to access this file">
                                                                 <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="h-4 w-4" viewBox="0 0 20 20"
                                                                     fill="currentColor">
                                                                     <path fill-rule="evenodd"
                                                                         d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                                                         clip-rule="evenodd" />
                                                                 </svg>
                                                             </x-jet-button>
                                                         @endif
                                                     @else
                                                         <x-jet-button
                                                             wire:click="downloadFile('{{ $item->file_name }}')"
                                                             class="px-1 py-1 rounded-full bg-blue-200 hover:bg-blue-300 active:hover:bg-blue-300 text-blue-900">
                                                             <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-4 w-4" viewBox="0 0 20 20"
                                                                 fill="currentColor">
                                                                 <path fill-rule="evenodd"
                                                                     d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                                                     clip-rule="evenodd" />
                                                             </svg>
                                                         </x-jet-button>
                                                         <x-jet-button
                                                             wire:click="updateShowModal({{ $item->id }})"
                                                             class="px-1 py-1 rounded-full bg-green-200 hover:bg-green-300 active:hover:bg-green-300 text-green-900">
                                                             <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-4 w-4" viewBox="0 0 20 20"
                                                                 fill="currentColor">
                                                                 <path
                                                                     d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                             </svg>
                                                         </x-jet-button>
                                                         <x-jet-danger-button
                                                             wire:click="deleteShowModal({{ $item->id }})"
                                                             class="px-1 py-1 rounded-full bg-red-200 hover:bg-red-300 active:hover:bg-red-300 text-red-900">
                                                             <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-4 w-4" viewBox="0 0 20 20"
                                                                 fill="currentColor">
                                                                 <path fill-rule="evenodd"
                                                                     d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                     clip-rule="evenodd" />
                                                             </svg>
                                                             </x-jet-button>
                                                     @endif
                                                 </td>
                                             </tr>
                                         @endforeach
                                     @else
                                         <tr>
                                             <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan="10">
                                                 No
                                                 Document
                                                 added</td>
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
         @endif

         <x-jet-dialog-modal wire:model="modalFormVisible">
             <x-slot name="title">
                 {{ __('Save') }}
             </x-slot>
             <x-slot name="content">
                 <div class="mt-4">
                     <x-jet-label for="title" value="{{ __('Title') }}" class="mb-2" />
                     <x-jet-input id="title" class="block mt-1 w-full text-sm" type="text"
                         wire:model.debounce.800ms="title" />
                     @error('title') <span class="error">{{ $message }}</span> @enderror
                 </div>
                 <div class="mt-4">
                     <x-jet-label for="description" value="{{ __('Description') }}" class="mb-2" />
                     <x-jet-input id="description" class="block mt-1 w-full text-sm" type="text"
                         wire:model.debounce.800ms="description" />
                     @error('description') <span class="error">{{ $message }}</span> @enderror
                 </div>

                 <div class="mt-4">
                     <x-jet-label for="files" value="{{ __('Files') }}" class="mb-2" />
                     <x-jet-input id="files" class="block mt-1 w-full text-sm rounded-none" type="file"
                         wire:model="files" />
                     @error('files') <span class="error">{{ $message }}</span> @enderror
                 </div>

                 @include('livewire.includes.designation-dropdown', ['desig' => $desig])

             </x-slot>

             <x-slot name="footer">
                 <x-jet-secondary-button wire:click.prevent="$toggle('modalFormVisible')" wire:loading.attr="disabled"
                     class="bg-gray-200 hover:bg-gray-300 active:hover:bg-gray-300 text-gray-900">
                     {{ __('Cancel') }}
                 </x-jet-secondary-button>


                 @if ($modelId)
                     <x-jet-danger-button
                         class="ml-2 bg-green-200 hover:bg-green-300 active:hover:bg-green-300 text-green-900"
                         wire:click="update" wire:loading.attr="disabled">
                         {{ __('Update') }}
                     </x-jet-danger-button>
                 @else
                     <x-jet-danger-button
                         class="ml-2 bg-green-200 hover:bg-green-300 active:hover:bg-green-300 text-green-900"
                         wire:click="create" wire:loading.attr="disabled">
                         {{ __('Save') }}
                     </x-jet-danger-button>
                 @endif

             </x-slot>
         </x-jet-dialog-modal>


         <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
             <x-slot name="title">
                 {{ __('Delete Document') }}
             </x-slot>

             <x-slot name="content">
                 {{ __('Are you sure you want to delete this documents? Once the document is deleted, all of its resources and data will be permanently deleted.') }}
             </x-slot>

             <x-slot name="footer">
                 <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                     {{ __('Cancel') }}
                 </x-jet-secondary-button>

                 <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                     {{ __('Delete Document') }}
                 </x-jet-danger-button>
             </x-slot>
         </x-jet-dialog-modal>

     </div>
 </div>
