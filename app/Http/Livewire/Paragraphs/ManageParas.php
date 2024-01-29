<?php

namespace App\Http\Livewire\Paragraphs;

use App\Models\Page;
use App\Models\Paragraph;
use Livewire\Component;

class ManageParas extends Component
{
    public $select;

    public $key = 0;

    public $thisid;

    public $content;

    public $paras;

    public $updateMode = false;

    public $createMode = false;

    public function render()
    {
        $this->paras = Paragraph::where('page_id', $this->select)->get();

        return view('livewire.paragraphs.manage-paras')
            ->withPagenames(Page::orderBy('name')->get());
    }

    public function save()
    {
        $data = $this->validate([
            'content' => 'required | min:5| max:15000',
        ]);

        Paragraph::create([
            'para_content' => $data['content'],
            'page_id' => $this->select,
        ]);

        $this->reset('createMode', 'content');
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Paragraph::where('id', $id);
            $record->delete();

            $this->reset('createMode', 'content');
        }
    }

    public function addPara()
    {
        $this->createMode = 'true';
    }

    public function editPara($id)
    {
        $editpara = Paragraph::find($id);
        $this->thisid = $editpara->id;
        $this->content = $editpara->para_content;

        $this->updateMode = 'true';
    }

    public function update()
    {
        $data = $this->validate([
            'content' => 'required | min:5| max:15000',

        ]);

        $updated = Paragraph::find($this->thisid);

        $updated->para_content = $data['content'];

        $updated->save();

        $this->reset('updateMode', 'content');
    }
}
