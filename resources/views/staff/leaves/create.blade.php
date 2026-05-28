{{-- resources/views/staff/leaves/create.blade.php --}}
@extends('layouts.app')

@section('title', 'ស្នើរសុំច្បាប់')

@section('content')
<div class="container-fluid">
    <div class="create-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title"> ស្នើរសុំច្បាប់</h1>
            <p class="page-sub">បំពេញព័ត៌មានខាងក្រោមដើម្បីស្នើរសុំច្បាប់</p>
        </div>
        <a href="{{ route('staff.leaves.index') }}" class="btn-back">← ត្រឡប់ក្រោយ</a>
    </div>

    <div class="form-card">
        @if($errors->any())
            <div class="alert alert-error">
                <strong>⚠️ មានកំហុស៖</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.leaves.store') }}" method="POST" id="leaveForm">
            @csrf

            {{-- Leave Type --}}
            <div class="form-group">
                <label class="form-label">ប្រភេទច្បាប់ <span class="required">*</span></label>
                <div class="type-grid">
                    @php
                        $types = [
                            'annual'   => ['label' => 'ច្បាប់ប្រចាំឆ្នាំ', 'icon' => '🗓️', 'color' => '#ebf8ff', 'border' => '#3182ce'],
                            'sick'     => ['label' => 'ច្បាប់ឈឺ',          'icon' => '🏥', 'color' => '#fff5f5', 'border' => '#e53e3e'],
                            'personal' => ['label' => 'ច្បាប់ផ្ទាល់ខ្លួន',  'icon' => '👤', 'color' => '#faf5ff', 'border' => '#805ad5'],
                            'unpaid'   => ['label' => 'ច្បាប់គ្មានប្រាក់ខែ','icon' => '💰', 'color' => '#fffbeb', 'border' => '#d97706'],
                        ];
                    @endphp
                    @foreach($types as $value => $info)
                    <label class="type-card" data-color="{{ $info['border'] }}" data-bg="{{ $info['color'] }}">
                        <input type="radio" name="type" value="{{ $value }}"
                               {{ old('type') === $value ? 'checked' : '' }}>
                        <span class="type-icon">{{ $info['icon'] }}</span>
                        <span class="type-label">{{ $info['label'] }}</span>
                    </label>
                    @endforeach
                </div>
                @error('type')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Dates --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="start_date">ថ្ងៃចាប់ផ្តើម <span class="required">*</span></label>
                    <input type="date" id="start_date" name="start_date"
                           class="form-input @error('start_date') input-error @enderror"
                           value="{{ old('start_date') }}"
                           min="{{ date('Y-m-d') }}">
                    @error('start_date')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="end_date">ថ្ងៃបញ្ចប់ <span class="required">*</span></label>
                    <input type="date" id="end_date" name="end_date"
                           class="form-input @error('end_date') input-error @enderror"
                           value="{{ old('end_date') }}"
                           min="{{ date('Y-m-d') }}">
                    @error('end_date')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Days Preview --}}
            <div class="days-preview" id="daysPreview" style="display:none">
                📅 សរុបប្រហែល <strong id="daysCount">0</strong> ថ្ងៃធ្វើការ
            </div>

            {{-- Reason --}}
            <div class="form-group">
                <label class="form-label" for="reason">
                    មូលហេតុ <span class="required">*</span>
                </label>
                <textarea id="reason" name="reason" rows="4"
                          class="form-input @error('reason') input-error @enderror"
                          placeholder="សូមពន្យល់អំពីមូលហេតុស្នើរសុំច្បាប់..."
                          maxlength="500">{{ old('reason') }}</textarea>
                <div class="char-count"><span id="charCount">0</span>/500</div>
                @error('reason')
                    <span class="field-error">{{ $message }}</span>
                @enderror   
            </div>

            {{-- Submit --}}
            <div class="form-actions">
                <a href="{{ route('staff.leaves.index') }}" class="btn-cancel">បោះបង់</a>
                <button type="submit" class="btn-submit">📤 បញ្ជូនការស្នើរសុំ</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
    .create-page { max-width: 100%; margin: 0 auto; padding: 1.5rem; }

    .page-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 1.5rem;
    }
    .page-title { font-size: 1.6rem; font-weight: 700; color: #1a202c; margin: 0; }
    .page-sub   { color: #718096; margin: .2rem 0 0; font-size: .9rem; }
    .btn-back   { color: #4a5568; text-decoration: none; font-size: .9rem; }
    .btn-back:hover { color: #1a202c; }

    .form-card { background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,.1); }

    /* Alerts */
    .alert        { padding: .85rem 1.2rem; border-radius: 8px; margin-bottom: 1.2rem; }
    .alert-error  { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
    .error-list   { margin: .4rem 0 0 1rem; }

    /* Form groups */
    .form-group   { margin-bottom: 1.3rem; }
    .form-label   { display: block; font-weight: 600; color: #4a5568; margin-bottom: .5rem; font-size: .9rem; }
    .required     { color: #e53e3e; }
    .form-row     { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-input {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid #e2e8f0;
        border-radius: 8px; font-size: .93rem; outline: none; transition: border .2s;
        box-sizing: border-box;
    }
    .form-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,.15); }
    .input-error  { border-color: #fc8181 !important; }
    .field-error  { color: #e53e3e; font-size: .82rem; margin-top: .3rem; display: block; }
    .char-count   { text-align: right; font-size: .8rem; color: #a0aec0; margin-top: .25rem; }

    /* Type cards */
    .type-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: .8rem;
    }
    .type-card {
        cursor: pointer; border: 2px solid #e2e8f0; border-radius: 10px;
        padding: 1rem .8rem; text-align: center; transition: all .2s;
        display: flex; flex-direction: column; align-items: center; gap: .4rem;
    }
    .type-card input { display: none; }
    .type-card.selected { border-color: var(--tc-border); background: var(--tc-bg); }
    .type-icon  { font-size: 1.8rem; }
    .type-label { font-size: .82rem; font-weight: 600; color: #4a5568; }

    /* Days preview */
    .days-preview {
        background: #ebf8ff; border: 1px solid #90cdf4; border-radius: 8px;
        padding: .65rem 1rem; margin-bottom: 1.3rem; color: #2b6cb0; font-size: .9rem;
    }

    /* Actions */
    .form-actions { display: flex; justify-content: flex-end; gap: .8rem; margin-top: 1.5rem; }
    .btn-cancel {
        padding: .65rem 1.4rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
        color: #4a5568; text-decoration: none; font-weight: 600; font-size: .9rem;
        transition: all .2s;
    }
    .btn-cancel:hover { background: #f7fafc; }
    .btn-submit {
        padding: .65rem 1.6rem; background: #667eea; color: #fff; border: none;
        border-radius: 8px; font-weight: 600; font-size: .9rem; cursor: pointer;
        transition: background .2s;
    }
    .btn-submit:hover { background: #5a67d8; }

    @media (max-width: 540px) {
        .form-row { grid-template-columns: 1fr; }
        .type-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Type card selection
    document.querySelectorAll('.type-card').forEach(card => {
        const input  = card.querySelector('input');
        const color  = card.dataset.color;
        const bg     = card.dataset.bg;

        if (input.checked) {
            card.classList.add('selected');
            card.style.setProperty('--tc-border', color);
            card.style.setProperty('--tc-bg', bg);
        }

        card.addEventListener('click', () => {
            document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            card.style.setProperty('--tc-border', color);
            card.style.setProperty('--tc-bg', bg);
        });
    });

    // Days calculator (simple weekday approximation)
    function calcDays() {
        const s = new Date(document.getElementById('start_date').value);
        const e = new Date(document.getElementById('end_date').value);
        if (!s || !e || e < s) { document.getElementById('daysPreview').style.display='none'; return; }
        let days = 0, cur = new Date(s);
        while (cur <= e) {
            const d = cur.getDay();
            if (d !== 0 && d !== 6) days++;
            cur.setDate(cur.getDate() + 1);
        }
        document.getElementById('daysCount').textContent = days;
        document.getElementById('daysPreview').style.display = 'block';
    }
    document.getElementById('start_date').addEventListener('change', calcDays);
    document.getElementById('end_date').addEventListener('change', calcDays);

    // End date min sync
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });

    // Char count
    const textarea = document.getElementById('reason');
    const counter  = document.getElementById('charCount');
    textarea.addEventListener('input', () => { counter.textContent = textarea.value.length; });
    counter.textContent = textarea.value.length;
</script>
@endpush
