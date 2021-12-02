<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Str;

use App\Models\FileRequest;
use App\Models\Document;

class NotificationsLivewire extends Component
{
    public $accessCode;

    public function render()
    {
        return view("livewire.notifications-livewire", [
            "data" => $this->read(),
        ]);
    }

    /**
     * read
     *
     * @return void
     */
    public function read()
    {
        /*=============== Changes ===================*/

        $data = FileRequest::join("users", "from", "users.id")
            ->join("documents", "file", "documents.id")
            ->join("designations", "designation_id", "designations.id")
            ->join("roles", "users.role_id", "roles.id")
            ->select(
                "file_requests.*",
                "roles.role_title",
                "designations.designation_title",
                "users.name",
                "documents.id as doc_id",
                "documents.file_name",
                "documents.access_code",
                "documents.title"
            )
            ->paginate(10);

        return $data;
        /* ===========================================*/
    }

    public function generateAccessCode($id, $doc_id)
    {
        $accessCode = Str::random(10);

        Document::where("id", $doc_id)->update([
            "access_code" => $accessCode,
        ]);

        FileRequest::where("id", $id)->update([
            "accepted" => 1,
            "read" => 1,
        ]);

        $this->dispatchBrowserEvent("access_code_generated");
    }

    public function denyRequest($id, $doc_id)
    {
        Document::where("id", $doc_id)->update([
            "access_code" => "",
        ]);

        FileRequest::where("id", $id)->update([
            "accepted" => 0,
            "read" => 1,
        ]);

        $this->dispatchBrowserEvent("request_denied");
    }
}
