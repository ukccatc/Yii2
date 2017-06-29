<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use Yii;

class Book extends ActiveRecord {
    
    public static function tableName() {
        return '{{book}}';
    }
    
    public function rules() {
        return [
            [['name', 'publisher_id'], 'required'],
        ];
    }
    
    public function getDatePublished() {
        return ($this->date_published) ? Yii::$app->formatter->asDate($this->date_published): 'Not set';
    }
    
    public function getPublisher() {
        return $this->hasOne(Publisher::className(), ['id' => 'publisher_id'])->one();
    }
    
    public function getPublisherName() {
        
        if ($publisher = $this->getPublisher()) {
            return $publisher->name;
        }
        return "Not set";
    }
    
    public function getBookToAuthorRelations() {
        
        return $this->hasMany(BookToAuthor::className(), ['book_id' => 'id']);
    }
    /*
     * @object Authors[]
     */
    public function getAuthors() {
        
        return $this->hasMany(Author::className(),['id' => 'author_id'])->via('bookToAuthorRelations')->all();
    }
    
    public function getFullName() {
        foreach($this->getAuthors() as $author) {
             echo "<p>$author->first_name $author->last_name $author->rating</p>";
        }
    }
}
