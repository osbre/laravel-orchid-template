<?php

declare(strict_types=1);

namespace Domain\User\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\{Label, CheckBox};
use Orchid\Screen\Layouts\Rows;
use Illuminate\Support\Collection;

class RolePermissionLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        return $this->generatedPermissionFields($this->query->getContent('permission'));
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function generatedPermissionFields(Collection $permissionsRaw): array
    {
        foreach ($permissionsRaw as $group => $items) {
            $fields[] = Label::make($group)
                ->title($group);

            foreach (collect($items)->chunk(3) as $chunks) {
                $fields[] = Field::group(function () use ($chunks) {
                    foreach ($chunks as $permission) {
                        $permissions[] = CheckBox::make('permissions.'.base64_encode($permission['slug']))
                            ->placeholder($permission['description'])
                            ->value((int) $permission['active']);
                    }

                    return $permissions ?? [];
                });
            }

            $fields[] = Label::make('close');
        }

        return $fields ?? [];
    }
}
