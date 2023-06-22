<?php

namespace App\Library\Imports\ShowTemplateMessages;

use App\Imports\ShowTemplateMessageImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Nyholm\Psr7\UploadedFile;

class ExcelImport
{
    protected array $data = [];

    protected ShowTemplateMessageImport $import;

    /**
     * Create a new import instance.
     */
    public function __construct(protected string|UploadedFile $file)
    {
        $this->import = new ShowTemplateMessageImport();
    }

    /**
     * Read the file and extract the data.
     */
    public function read(): array
    {
        $data = Excel::import(
            new ShowTemplateMessageImport(),
            $path = Storage::disk('local')->path($this->file),
            readerType: \Maatwebsite\Excel\Excel::XLSX,
        );

        $data = $this->import->import($path, 'local', \Maatwebsite\Excel\Excel::XLSX)

        unlink($path);

        return head($data);
    }
}
