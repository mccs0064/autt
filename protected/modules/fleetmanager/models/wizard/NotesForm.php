<?php


class NotesForm extends AccidentWizard
{
    public $notes;
    public $note_type;
    public $claim_cost;
    public function rules() {
        return array(
            array('note_type', 'required'),
            array('notes,claim_cost','safe')
        );
    }
    public function attributeLabels()
    {
        return array(
            'note_type'=>'Accident'
        );
    }

}
