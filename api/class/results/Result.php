<?php
class Result {
    public bool $success = false;
    public ?string $info = null;

    public function set_error(Throwable $e) {
        $this->success = false;
        $this->info = $e->getMessage();
    }
}
?>