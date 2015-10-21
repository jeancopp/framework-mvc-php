<?php

    class UploadHelper{
        protected $path = "uploads/";
        protected $file;
        protected $filename;
        protected $fileTmpName;
        
        public function setPath($path) {
            $this->path = $path;            
        }
        
        public function setFile($file) {
            $this->file = $file;
            $this->setFileName();
            $this->setFileTmpName();
        }
        
        protected function setFileName() {
            $this->filename = $file['name'];
        }
        
        protected function setFileTmpName() {
            $this->filename = $file['tmp_name'];
        }
        
        public function upload(){
            return move_uploaded_file($this->fileTmpName, 
                    $_SERVER["DOCUMENT_ROOT"] . $this->path . $this->filename );
        }
        
    }