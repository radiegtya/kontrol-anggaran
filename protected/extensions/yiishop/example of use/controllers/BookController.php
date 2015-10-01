<?php

class BookController extends Controller {

    /**
     * read cart data
     */
    public function actionIndex() {
        $positions = Yii::app()->shoppingCart->getPositions();
        foreach ($positions as $position) {
            echo $position->name . '<br/>';
            echo $position->getQuantity() . 'x' . $position->price . '=' . $position->getSumPrice() . '<br/><br/>';
        }

        echo "Total Item Type In Cart = " . Yii::app()->shoppingCart->getCount() . '<br/>';
        echo "Total Item In Cart = " . Yii::app()->shoppingCart->getItemsCount() . '<br/>';
        echo "Total Price= " . Yii::app()->shoppingCart->getCost() . '<br/>';
    }

    /**
     * put item on cart
     */
    public function actionPut($id) {
        $model = Book::model()->findByPk($id);
        Yii::app()->shoppingCart->put($model);
        echo "success to put";
    }

    /**
     * remove from cart     
     */
    public function actionRemove($id) {
        $model = Book::model()->findByPk($id);        
        Yii::app()->shoppingCart->remove($model->getId());
        echo "success to remove";
    }
    
    /**
     * update cart
     * @param type $id
     * @param type $qty
     */
    public function actionUpdate($id, $qty) {
        $model = Book::model()->findByPk($id);           
        Yii::app()->shoppingCart->update($model, $qty);
        echo "success to update";
    }

}