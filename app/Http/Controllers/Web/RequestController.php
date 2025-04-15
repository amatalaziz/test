<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request as SupportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequestController extends Controller
{
   public function index(): View
{
    if (auth()->user()->isAdmin()) {
        // إذا كان المستخدم ادمن، عرض جميع الطلبات
        $requests = SupportRequest::all();
    } else {
        // إذا كان المستخدم عادي، عرض طلباته فقط
        $requests = auth()->user()->requests; // assuming there is a relationship defined in the User model
    }

    return view('requests.index', compact('requests'));
}


    public function create(): View
    {
        return view('requests.create');
    }

    public function store(StoreRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        SupportRequest::create($validated);

        return redirect()->route('requests.index')
            ->with('success', 'Request created successfully.');
    }

    public function show(SupportRequest $request): View
    {
        $this->authorize('view', $request);

        return view('requests.show', compact('request'));
    }

    public function edit(SupportRequest $request): View
    {
        $this->authorize('update', $request);

        return view('requests.edit', compact('request'));
    }

    public function update(UpdateRequestRequest $request, SupportRequest $requestModel)
    {
        $requestModel->update($request->validated());

        return redirect()->route('requests.show', $requestModel)
            ->with('success', 'Request updated successfully.');
    }

    public function destroy(SupportRequest $request): RedirectResponse
    {
        $this->authorize('delete', $request);

        $request->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted successfully.');
    }
}
