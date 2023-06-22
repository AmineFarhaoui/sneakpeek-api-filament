<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShowTemplateMessageImport implements SkipsEmptyRows, WithHeadingRow, WithValidation, ToArray
{
    use Importable;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            'actor_id' => 'nullable|integer',
            'day' => 'required|integer',
            'week' => 'required|integer',
            'time' => 'required|date',
            'message' => 'required|string',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function array(array $array): array
    {
        return $array;
    }
}
