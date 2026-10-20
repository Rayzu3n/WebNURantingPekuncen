<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\BanomMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BanomController extends Controller
{
    public function index(): View
    {
        $banoms = Banom::query()
            ->withCount('members')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.banoms.index', compact('banoms'));
    }

    public function create(): View
    {
        return view('admin.banoms.form', [
            'banom' => new Banom(['is_active' => true]),
            'members' => old('members', []),
            'action' => route('admin.banoms.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $members = $data['members'] ?? [];
        unset($data['members']);

        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? ((Banom::max('sort_order') ?? 0) + 1));
        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($data, $members): void {
            $banom = Banom::create($data);
            $this->saveMembers($banom, $members);
        });

        return redirect()->route('admin.banoms.index')
            ->with('success', 'Data Banom berhasil ditambahkan.');
    }

    public function edit(Banom $banom): View
    {
        $members = old('members', $banom->members
            ->map(fn (BanomMember $member): array => [
                'position' => $member->position,
                'name' => $member->name,
            ])
            ->values()
            ->all());

        return view('admin.banoms.form', [
            'banom' => $banom,
            'members' => $members,
            'action' => route('admin.banoms.update', $banom),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Banom $banom): RedirectResponse
    {
        $data = $this->validatedData($request);
        $members = $data['members'] ?? [];
        unset($data['members']);

        $data['sort_order'] = (int) ($data['sort_order'] ?? $banom->sort_order);
        $data['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($banom, $data, $members): void {
            $banom->update($data);
            $this->saveMembers($banom, $members);
        });

        return redirect()->route('admin.banoms.index')
            ->with('success', 'Data Banom berhasil diperbarui.');
    }

    public function destroy(Banom $banom): RedirectResponse
    {
        $banom->delete();

        return redirect()->route('admin.banoms.index')
            ->with('success', 'Data Banom berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:160'],
            'title' => ['nullable', 'string', 'max:255'],
            'motto' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'term' => ['nullable', 'string', 'max:120'],
            'coverage' => ['nullable', 'string', 'max:255'],
            'legal_status' => ['nullable', 'string', 'max:160'],
            'note' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
            'members' => ['nullable', 'array', 'max:100'],
            'members.*.position' => ['required', 'string', 'max:160'],
            'members.*.name' => ['required', 'string', 'max:160'],
        ]);
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'banom';
        $slug = $base;
        $suffix = 2;

        while (Banom::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /**
     * @param array<int, array{position: string, name: string}> $members
     */
    private function saveMembers(Banom $banom, array $members): void
    {
        BanomMember::query()->where('banom_id', $banom->id)->delete();

        foreach (array_values($members) as $sortOrder => $member) {
            $banom->members()->create([
                'position' => $member['position'],
                'name' => $member['name'],
                'sort_order' => $sortOrder,
            ]);
        }
    }
}
