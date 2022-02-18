<div class="mt-4">
    <x-jet-label for="designation" value="{{ __('Select designation') }}" class="mb-2" />
    {{ Auth::user()->isDean }}
    <select name="designation_id"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full text-sm"
        wire:model="designation_id">
        <option value="">Please select designation</option>
        @php
            $limit_designations = [];

            if (Auth::user()->role->code == 'dean') {
                $limit_designation = ['purp', 'facu', 'inst', 'lab', 'sps'];
            }

            if (Auth::user()->role->code == 'hrdo') {
                $limit_designation = ['dc', 'purp', 'facu', 'inst', 'lab', 'sps'];
            }

            if (Auth::user()->role->code == 'coll_co') {
                $limit_designation = ['purp', 'facu', 'inst', 'lib', 'lab', 'sps', 'ppf', 'socd', 'oa', 'exh'];
            }

            if (Auth::user()->role->code == 'scho_co') {
                $limit_designation = ['facu', 'inst', 'sps', 'ppf', 'socd', 'oa'];
            }

            if (Auth::user()->role->code == 'libr') {
                $limit_designation = ['lib', 'lab'];
            }

            if (Auth::user()->role->code == 'unit_head') {
                $limit_designation = ['purp', 'inst', 'ppf', 'sps', 'socd', 'oa'];
            }

            if (Auth::user()->role->code == 'board') {
                $limit_designation = ['ppf', 'sps', 'socd'];
            }

            if (Auth::user()->role->code == 'coll_pres') {
                $limit_designation = ['purp', 'facu', 'inst', 'lib', 'lab', 'ppf', 'sps', 'socd', 'oa'];
            }

            if (Auth::user()->role->code == 'admin') {
                $limit_designation = ['dc', 'purp', 'facu', 'inst', 'lib', 'lab', 'ppf', 'sps', 'socd', 'oa'];
            }

            if (Auth::user()->role->code == 'paascu') {
                $limit_designation = ['purp', 'exh'];
            }

        @endphp
        @foreach (App\Models\Designation::all() as $designation)
            @foreach ($limit_designation as $limit_d)
                @if ($designation->code == $limit_d)
                    <option value="{{ $designation->id }}">
                        {{ $designation->designation_title }}</option>
                @endif
            @endforeach
        @endforeach
    </select>
</div>
