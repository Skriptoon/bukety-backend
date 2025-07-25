<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorageConditionsTemplates\StoreStorageConditionsTemplatesRequest;
use App\Models\StorageConditionsTemplate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StorageConditionsTemplateController extends Controller
{
    public function index(): Response
    {
        $storageConditionsTemplates = StorageConditionsTemplate::all();

        return Inertia::render('StorageConditionsTemplate/Index', [
            'storageConditionsTemplates' => $storageConditionsTemplates,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('StorageConditionsTemplate/Create');
    }

    public function store(StoreStorageConditionsTemplatesRequest $request): RedirectResponse
    {
        StorageConditionsTemplate::create($request->validated());

        return redirect()->route('storage-conditions-templates.index');
    }

    public function edit(StorageConditionsTemplate $storageConditionsTemplate): Response
    {
        return Inertia::render('StorageConditionsTemplate/Edit', [
            'storageConditionsTemplate' => $storageConditionsTemplate,
        ]);
    }

    public function update(
        StorageConditionsTemplate $storageConditionsTemplate,
        StoreStorageConditionsTemplatesRequest $request
    ): RedirectResponse {
        $storageConditionsTemplate->update($request->validated());

        return redirect()->route('storage-conditions-templates.index');
    }

    public function destroy(StorageConditionsTemplate $storageConditionsTemplate): RedirectResponse
    {
        $storageConditionsTemplate->delete();

        return redirect()->route('storage-conditions-templates.index');
    }
}
