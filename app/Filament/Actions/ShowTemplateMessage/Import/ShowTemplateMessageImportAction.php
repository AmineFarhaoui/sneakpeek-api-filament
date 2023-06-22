<?php

namespace App\Filament\Actions\ShowTemplateMessage\Import;

use App\Imports\ShowTemplateMessageImport;
use App\Jobs\ImportShowTemplateMessages;
use Closure;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ShowTemplateMessageImportAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Import';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->action($this->import());

        $this->form([
            \Filament\Forms\Components\FileUpload::make('file')
                ->disk('public')
                ->preserveFilenames(),
            //  ->acceptedFileTypes(['xlsx', 'xls', 'csv']), //TODO: Fix this
        ]);
    }

    /**
     * Get the action callback.
     */
    public function import(): Closure
    {
        return function (array $data) {
            $data = (new ShowTemplateMessageImport())->import(
                $path = Storage::disk('local')->path($data['file']),
                readerType: Excel::XLSX,
            );

            unlink($path);

            ImportShowTemplateMessages::dispatch(
                $data,
                $this->record,
                current_user()
            );
        };
    }
}
