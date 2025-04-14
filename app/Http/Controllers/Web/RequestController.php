<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        return view('requests.index');
    }

    public function create(): View
    {
        return view('requests.create');
    }

    public function store(StoreRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        Request::create($validated);

        return redirect()->route('requests.index')
            ->with('success', 'Request created successfully.');
    }

    public function show(Request $request): View
    {
        $this->authorize('view', $request);

        return view('requests.show', compact('request'));
    }

    public function edit(Request $request): View
    {
        $this->authorize('update', $request);

        return view('requests.edit', compact('request'));
    }

    public function update(UpdateRequestRequest $request, Request $requestModel): RedirectResponse
    {
        $requestModel->update($request->validated());

        return redirect()->route('requests.show', $requestModel)
            ->with('success', 'Request updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', $request);

        $request->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted successfully.');
    }
}