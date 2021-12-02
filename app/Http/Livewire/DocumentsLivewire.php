<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Document;
use App\Models\Designation;
use App\Models\FileRequest;

use Livewire\Component;
use Livewire\WithPagination;

/*=============== Changes ===================*/

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*=============================================*/

class DocumentsLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $title;
    public $description;
    public $files;
    public $uploaded_by;
    public $designation_id;
    public $accessCode;
    public $designation;

    protected $queryString = ["designation"];

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            "title" => "required",
            "description" => "required",
        ];
    }

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->designation_id = $this->designation
            ? Designation::where("code", $this->designation)->first()->id
            : null;

        //reset the pagination after reloading the page

        $this->resetPage();
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        /*=============== Changes ===================*/
        $page = new Document();
        $page->title = $this->title;
        $page->description = $this->description;
        $page->file_name = $this->files->getClientOriginalName();
        $page->designation_id = $this->designation_id;
        $page->uploaded_by = Auth::user()->id;

        //Store file to file folder in storage
        $this->files->storeAs("files", $this->files->getClientOriginalName());

        $page->save();

        /* ======================================== */

        $this->modalFormVisible = false;
        $this->resetVars();
    }

    /**
     * read
     *
     * @return void
     */
    public function read()
    {
        $d = Designation::where("code", $this->designation)->first();

        $access_own_files_only = [
            "hrdo",
            "unit_head",
            "scho_co",
            "board",
            "libr",
        ];
        $access_all_files = ["accr_co", "accr"];

        switch (Auth::user()->role->code) {
            case "admin":
                if ($this->designation) {
                    $data = Document::join(
                        "users",
                        "documents.uploaded_by",
                        "=",
                        "users.id"
                    )
                        ->join(
                            "departments",
                            "users.dept_id",
                            "=",
                            "departments.id"
                        )
                        ->select("documents.*", "name", "dept_name")
                        ->where("designation_id", $d->id)
                        ->paginate(10);
                } else {
                    $data = [];
                }
                break;
            case "dean":
                if ($this->designation) {
                    $data =
                        $this->designation == "dc"
                            ? Document::join(
                                "users",
                                "documents.uploaded_by",
                                "=",
                                "users.id"
                            )
                                ->join(
                                    "departments",
                                    "users.dept_id",
                                    "=",
                                    "departments.id"
                                )
                                ->where("designation_id", $d->id)
                                ->select("documents.*", "name", "dept_name")
                                ->paginate(10)
                            : Document::join(
                                "users",
                                "documents.uploaded_by",
                                "=",
                                "users.id"
                            )
                                ->join(
                                    "departments",
                                    "users.dept_id",
                                    "=",
                                    "departments.id"
                                )
                                ->where("dept_id", Auth::user()->dept->id)
                                ->where("designation_id", $d->id)
                                ->select("documents.*", "name", "dept_name")
                                ->paginate(10);
                } else {
                    $data = [];
                }
                break;
            case in_array(Auth::user()->role->code, $access_own_files_only):
                $data = $this->designation
                    ? Document::join(
                        "users",
                        "documents.uploaded_by",
                        "=",
                        "users.id"
                    )
                        ->join(
                            "departments",
                            "users.dept_id",
                            "=",
                            "departments.id"
                        )
                        ->where("uploaded_by", Auth::user()->id)
                        ->where("designation_id", $d->id)
                        ->select("documents.*", "name", "dept_name")
                        ->paginate(10)
                    : [];
                break;
            case "coll_co":
                if ($this->designation) {
                    $data = Document::join(
                        "users",
                        "documents.uploaded_by",
                        "=",
                        "users.id"
                    )
                        ->join(
                            "departments",
                            "users.dept_id",
                            "=",
                            "departments.id"
                        )
                        ->where("dept_id", Auth::user()->dept->id)
                        ->where("designation_id", $d->id)
                        ->select("documents.*", "name", "dept_name")
                        ->paginate(10);
                } else {
                    $data = [];
                }
                break;
            case in_array(Auth::user()->role->code, $access_all_files):
                $data = $this->designation
                    ? Document::join(
                        "users",
                        "documents.uploaded_by",
                        "=",
                        "users.id"
                    )
                        ->join(
                            "departments",
                            "users.dept_id",
                            "=",
                            "departments.id"
                        )
                        ->where("designation_id", $d->id)
                        ->select("documents.*", "name", "dept_name")
                        ->paginate(10)
                    : [];
                break;
            default:
                $data = $this->designation
                    ? Document::where(
                        "uploaded_by",
                        Auth::user()->id
                    )->paginate(10)
                    : [];
                break;
        }

        return $data;
        /* ===========================================*/
    }

    public function update()
    {
        $this->validate();
        /*=============== Changes ===================*/

        $doc = Document::find($this->modelId);
        $doc->title = $this->title;
        $doc->description = $this->description;
        $doc->designation_id = $this->designation_id;

        if (!is_string($this->files)) {
            $doc->file_name = $this->files->getClientOriginalName();
            $this->files->storeAs(
                "files",
                $this->files->getClientOriginalName()
            );
        } else {
            $doc->file_name = $this->files;
        }

        $doc->save();
        $this->resetVars();

        /* ======================================== */
        $this->modalFormVisible = false;
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        Document::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->dispatchBrowserEvent("file_deleted");
        $this->resetPage();
    }
    /**
     * createShowModal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }

    /**
     * updateShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    /**
     * deleteShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    /**
     * loadModel
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Document::find($this->modelId);
        $this->title = $data->title;
        $this->description = $data->description;
        $this->files = $data->file_name;
        /*=============== Changes ===================*/
        $this->uploaded_by = $data->uploaded_by;
        $this->designation_id = $data->designation_id;
        /*============================================*/
    }

    public function modelData()
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "files" => $this->files,
            "designation_id" => $this->designation_id,
        ];
    }

    /**
     * cleanVars
     *
     * @return void
     */
    public function resetVars()
    {
        $this->modelId = null;
        $this->title = null;
        $this->description = null;
        $this->files = null;
        $this->designation_id = null;
    }
    /**
     * render`````````````````````````````````````````
     *
     * @return void
     */
    public function render()
    {
        $desig = $this->designation
            ? Designation::where("code", $this->designation)->first()
            : null;

        return view("livewire.documents-livewire", [
            "data" => $this->read(),
            "desig" => $desig,
        ]);
    }

    /*=============== Changes ===================*/

    // Downlaod file

    public function downloadFile($file)
    {
        return Storage::disk("files")->download($file);
    }

    public function requestFile($id)
    {
        //Check if file request already exists
        $file = FileRequest::where("from", Auth::user()->id)
            ->where("file", $id)
            ->first();

        if ($file) {
            $this->dispatchBrowserEvent("request_exists");
        } else {
            FileRequest::create([
                "from" => Auth::user()->id,
                "file" => $id,
            ]);
            $this->dispatchBrowserEvent("file_requested");
        }
    }

    public function generateAccessCode($id)
    {
        $accessCode = Str::random(10);

        Document::where("id", $id)->update([
            "access_code" => $accessCode,
        ]);
    }

    /* ==========================================*/
}
