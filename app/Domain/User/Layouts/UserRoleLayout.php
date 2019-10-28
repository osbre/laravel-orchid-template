<?php

declare(strict_types=1);

namespace Domain\User\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\{Label, Select, CheckBox};
use Illuminate\Support\Collection;

class UserRoleLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        $fields[] = Select::make('user.roles.')
            ->fromModel(Role::class, 'name')
            ->multiple()
            ->horizontal()
            ->title(__('Name role'));

        $permissionFields = $this->generatedPermissionFields($this->query->getContent('permission'));

        return array_merge($fields, $permissionFields);
    }

    /**
     * @param Collection $permissionsRaw
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
    public function generatedPermissionFields(Collection $permissionsRaw) : array
    {
        foreach ($permissionsRaw as $group => $items) {
            $fields[] = Label::make($group)
                ->title($group)
                ->horizontal();

            foreach (collect($items)->chunk(3) as $chunks) {
                $fields[] = Field::group(function () use ($chunks) {
                    foreach ($chunks as $permission) {
                        $permissions[] = CheckBox::make('permissions.'.base64_encode($permission['slug']))
                            ->placeholder($permission['description'])
                            ->value($permission['active'])
                            ->sendTrueOrFalse();
                    }

                    return $permissions ?? [];
                });
            }
        }

        return $fields ?? [];
    }
}
