<?php

class Contact extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contact';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, subject, message,date_sent', 'required'),
            array('id, name, email, subject, message,date_sent', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->user1);
        $criteria->compare('email', $this->user2);
        $criteria->compare('subject', $this->user1_email, true);
        $criteria->compare('message', $this->user2_email, true);
        $criteria->compare('date_sent', $this->date_sent, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
