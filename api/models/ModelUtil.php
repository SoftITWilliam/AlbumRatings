
<?php

function update_model(IStandardModel $model, array $params, string $primary_field) {
    if(isset($params[$primary_field])) {
        apply_where_attribute($model, $model->get($params[$primary_field])->object, DataColumn::class);
    }
    apply_where_attribute($model, $params, DataColumn::class);
}

?>