<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-sort">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
			'class' => 'form-sort-book'
        ],
    ]); ?>
	<?php $sortTypes = [
            'name', 'Rating', 'view_count', 'last_read', 'updated_at'
    ] ?>
    <select name="sort" class="mr-3">
        <option value="name">Name</option>
        <option value="rating">Rating</option>
        <option value="view_count">Views</option>
        <option value="last_read">Last read</option>
        <option value="updated_at">Updated</option>
    </select>
    <!--    --><?php /* echo $form->field($model, 'sort')->dropdownList(
		$sortTypes, ['prompt' => 'Select Sort']
	) */?>

    <div class="form-group actions">
        <button class="btn" id="btn-sort" value="desc">
            <svg class="icon-asc" width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                <g>
                    <path fill="color" d="M 7.847656 12.046875 L 6.375 12.046875 L 6.375 0.367188 C 6.375 0.164062 6.210938 0 6.007812 0 L 3.046875 0 C 2.84375 0 2.679688 0.164062 2.679688 0.367188 L 2.679688 12.046875 L 1.207031 12.046875 C 1.066406 12.046875 0.9375 12.128906 0.875 12.257812 C 0.8125 12.382812 0.832031 12.535156 0.921875 12.644531 L 4.242188 17.597656 C 4.308594 17.683594 4.414062 17.734375 4.527344 17.734375 C 4.636719 17.734375 4.742188 17.683594 4.8125 17.597656 L 8.132812 12.644531 C 8.222656 12.535156 8.238281 12.382812 8.179688 12.257812 C 8.117188 12.128906 7.988281 12.046875 7.847656 12.046875 Z M 7.847656 12.046875 "/>
                    <path fill="color" d="M 17.082031 7.222656 L 14.632812 0.28125 C 14.582031 0.136719 14.441406 0.0390625 14.285156 0.0390625 L 13.578125 0.0390625 C 13.558594 0.0390625 13.539062 0.0390625 13.519531 0.0429688 C 13.5 0.0390625 13.480469 0.0390625 13.460938 0.0390625 L 12.769531 0.0390625 C 12.613281 0.0390625 12.476562 0.136719 12.421875 0.285156 L 9.984375 7.222656 C 9.945312 7.332031 9.960938 7.457031 10.03125 7.554688 C 10.101562 7.652344 10.210938 7.710938 10.332031 7.710938 L 11.390625 7.710938 C 11.554688 7.710938 11.695312 7.605469 11.742188 7.449219 L 12.207031 5.921875 L 14.855469 5.921875 L 15.324219 7.449219 C 15.371094 7.605469 15.511719 7.710938 15.675781 7.710938 L 16.734375 7.710938 C 16.851562 7.710938 16.964844 7.652344 17.035156 7.554688 C 17.101562 7.457031 17.121094 7.332031 17.082031 7.222656 Z M 12.648438 4.460938 C 13.089844 3.03125 13.386719 2.042969 13.535156 1.515625 L 14.4375 4.460938 Z M 12.648438 4.460938 "/>
                    <path fill="color" d="M 16.027344 16.5 L 12.753906 16.5 L 16.230469 11.503906 C 16.273438 11.441406 16.296875 11.371094 16.296875 11.292969 L 16.296875 10.667969 C 16.296875 10.464844 16.132812 10.300781 15.929688 10.300781 L 11.140625 10.300781 C 10.9375 10.300781 10.773438 10.464844 10.773438 10.667969 L 10.773438 11.371094 C 10.773438 11.574219 10.9375 11.738281 11.140625 11.738281 L 14.222656 11.738281 L 10.742188 16.730469 C 10.699219 16.792969 10.675781 16.867188 10.675781 16.941406 L 10.675781 17.574219 C 10.675781 17.777344 10.839844 17.941406 11.042969 17.941406 L 16.027344 17.941406 C 16.230469 17.941406 16.394531 17.777344 16.394531 17.574219 L 16.394531 16.867188 C 16.394531 16.664062 16.230469 16.5 16.027344 16.5 Z M 16.027344 16.5 "/>
                </g>
            </svg>
            <svg class="icon-desc" width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                <g>
                    <path fill="color" d="M 7.855469 12.046875 L 6.382812 12.046875 L 6.382812 0.367188 C 6.382812 0.164062 6.21875 0 6.015625 0 L 3.050781 0 C 2.851562 0 2.683594 0.164062 2.683594 0.367188 L 2.683594 12.046875 L 1.214844 12.046875 C 1.074219 12.046875 0.945312 12.128906 0.882812 12.257812 C 0.820312 12.382812 0.839844 12.535156 0.929688 12.644531 L 4.246094 17.597656 C 4.316406 17.683594 4.421875 17.734375 4.535156 17.734375 C 4.644531 17.734375 4.75 17.683594 4.820312 17.597656 L 8.140625 12.644531 C 8.230469 12.535156 8.246094 12.382812 8.183594 12.257812 C 8.125 12.128906 7.996094 12.046875 7.855469 12.046875 Z M 7.855469 12.046875 "/>
                    <path fill="color" d="M 17.089844 17.46875 L 14.640625 10.527344 C 14.589844 10.382812 14.449219 10.285156 14.292969 10.285156 L 13.585938 10.285156 C 13.566406 10.285156 13.546875 10.285156 13.527344 10.289062 C 13.507812 10.285156 13.488281 10.285156 13.46875 10.285156 L 12.777344 10.285156 C 12.621094 10.285156 12.484375 10.382812 12.429688 10.527344 L 9.992188 17.46875 C 9.953125 17.578125 9.96875 17.703125 10.039062 17.800781 C 10.109375 17.898438 10.21875 17.957031 10.339844 17.957031 L 11.398438 17.957031 C 11.5625 17.957031 11.703125 17.851562 11.75 17.695312 L 12.214844 16.167969 L 14.863281 16.167969 L 15.332031 17.695312 C 15.378906 17.851562 15.519531 17.957031 15.683594 17.957031 L 16.742188 17.957031 C 16.863281 17.957031 16.972656 17.898438 17.042969 17.800781 C 17.109375 17.703125 17.128906 17.578125 17.089844 17.46875 Z M 12.65625 14.707031 C 13.097656 13.277344 13.394531 12.289062 13.542969 11.757812 L 14.445312 14.707031 Z M 12.65625 14.707031 "/>
                    <path fill="color" d="M 16.035156 6.253906 L 12.761719 6.253906 L 16.238281 1.257812 C 16.28125 1.195312 16.304688 1.121094 16.304688 1.046875 L 16.304688 0.421875 C 16.304688 0.21875 16.140625 0.0546875 15.9375 0.0546875 L 11.148438 0.0546875 C 10.945312 0.0546875 10.78125 0.21875 10.78125 0.421875 L 10.78125 1.125 C 10.78125 1.328125 10.945312 1.492188 11.148438 1.492188 L 14.230469 1.492188 L 10.75 6.484375 C 10.707031 6.546875 10.683594 6.621094 10.683594 6.695312 L 10.683594 7.328125 C 10.683594 7.53125 10.847656 7.695312 11.050781 7.695312 L 16.035156 7.695312 C 16.238281 7.695312 16.402344 7.53125 16.402344 7.328125 L 16.402344 6.621094 C 16.402344 6.417969 16.238281 6.253906 16.035156 6.253906 Z M 16.035156 6.253906 "/>
                </g>
            </svg>
        </button>
		<?= Html::submitButton('Sort', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>