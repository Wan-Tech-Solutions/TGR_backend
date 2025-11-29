@extends('website.layouts.main')

@section('title')
    Book Consultation
@endsection

@section('content')
    @php
        $countryDialCodes = include resource_path('views/website/features/data/country-dial-codes.php');
        $availability = $availability ?? [];
        $dailyCapacity = $dailyCapacity ?? \App\Models\Consultation::DAILY_CAPACITY;
        $hourlyRate = $hourlyRate ?? \App\Models\Consultation::HOURLY_RATE;
        $selectedDate = old('selected_date') ?? ($selectedDate ?? null);
        $selectedHours = (int) (old('consultation_hours') ?? ($selectedHours ?? 1));
        $client_name = old('client_name') ?? ($client_name ?? null);
        $client_email = old('client_email') ?? ($client_email ?? null);
        $dial_code = old('dial_code') ?? ($dial_code ?? '+233');
        $client_phone = old('client_phone') ?? ($client_phone ?? null);
        $client_nationality = old('client_nationality') ?? ($client_nationality ?? null);
        $country_of_residence = old('country_of_residence') ?? ($country_of_residence ?? null);
        $rebook_of = old('rebook_of') ?? ($rebook_of ?? null);
        try {
            $selectedDateFormatted = $selectedDate
                ? \Illuminate\Support\Carbon::parse($selectedDate)->format('l, M j, Y')
                : 'None yet';
        } catch (\Throwable $exception) {
            $selectedDateFormatted = 'None yet';
        }
        $initialTotal = number_format($selectedHours * $hourlyRate, 2, '.', '');
    @endphp
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css"
        onerror="this.remove(); const fallback=document.createElement('link'); fallback.rel='stylesheet'; fallback.href='{{ asset('vendor/fullcalendar/main-5.11.5.min.css') }}'; document.head.appendChild(fallback);">

    <section
        class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
        style="background-image: url({{ asset('img/page-header/page-header-background.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1>Schedule Your <strong>Consultation</strong></h1>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Advisory</li>
                        <li><a href="{{ route('features.consult') }}">Consultation</a></li>
                        <li class="active">Book</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid py-5 consult-booking px-3 px-lg-5">
        <div class="row g-4 g-xl-5 align-items-start justify-content-between">
            <div class="col-lg-7 col-xl-7 col-xxl-7">
                <div class="consult-card shadow-lg border-0 h-100">
                    <div class="consult-card__body p-4 p-xl-5">
                        <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
                            <div>
                                <h2 class="mb-1 text-dark fw-bold">Tell Us About You</h2>
                                <p class="text-muted mb-0">Answer a few quick questions so we can tailor the consultation
                                    experience.</p>
                            </div>
                            <span class="badge rounded-pill bg-secondary-emphasis text-uppercase fw-semibold px-3 py-2">
                                $50 / hour
                            </span>
                        </div>

                        @if ($rebook_of)
                            <div class="alert alert-info d-flex align-items-start gap-2 rounded-3 mb-4 small">
                                <i class="fas fa-redo text-info mt-1"></i>
                                <div>
                                    <strong>Rebook in Progress</strong><br>
                                    Your previous consultation information has been automatically prefilled below. You can update any details as needed.
                                </div>
                            </div>
                        @endif
                        <form id="consultation-intake" action="{{ route('features.consult.store') }}" method="POST" novalidate>
                            @csrf
                            @if ($rebook_of)
                                <input type="hidden" name="rebook_of" value="{{ $rebook_of }}">
                            @endif
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase text-2 fw-semibold" for="client_name">Full
                                        Name</label>
                                    <input type="text" class="form-control form-control-lg" id="client_name"
                                        name="client_name" placeholder="Eg. Ama Mensah" value="{{ $client_name }}"
                                        required>
                                    @error('client_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase text-2 fw-semibold" for="client_email">Email
                                        Address</label>
                                    <input type="email" class="form-control form-control-lg" id="client_email"
                                        name="client_email" placeholder="you@example.com"
                                        value="{{ $client_email }}" required>
                                    @error('client_email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase text-2 fw-semibold" for="dial_code">Phone</label>
                                    <div class="input-group input-group-lg consult-phone-group">
                                        <span class="input-group-text bg-light border-end-0 pe-0">
                                            <select class="form-select form-select-lg border-0 bg-transparent"
                                                name="dial_code" id="dial_code" required>
                                                @foreach ($countryDialCodes as $country)
                                                    <option value="{{ $country['dial_code'] }}"
                                                        @selected($dial_code === $country['dial_code'])>
                                                        {{ $country['name'] }} ({{ $country['dial_code'] }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <input type="tel" class="form-control form-control-lg border-start-0"
                                            id="client_phone" name="client_phone" placeholder="000 000 000" inputmode="numeric"
                                            pattern="\d{9}" maxlength="9" value="{{ $client_phone }}" required>
                                    </div>
                                    <small class="text-muted d-block mt-1">Choose your country code, then enter your phone
                                        number.</small>
                                    @error('dial_code')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @error('client_phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase text-2 fw-semibold"
                                        for="client_nationality">Nationality</label>
                                    <input type="text" class="form-control form-control-lg" id="client_nationality"
                                        name="client_nationality" placeholder="Eg. Ghanaian"
                                        value="{{ $client_nationality }}">
                                    @error('client_nationality')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-uppercase text-2 fw-semibold d-block mb-2"
                                    for="country_of_residence">Country of Residence</label>
                                <input type="text" class="form-control form-control-lg" id="country_of_residence"
                                    name="country_of_residence" placeholder="Eg. Ghana" list="country-residence-options"
                                    value="{{ $country_of_residence }}" required>
                                <datalist id="country-residence-options">
                                    @foreach ($countryDialCodes as $country)
                                        <option value="{{ $country['name'] }}"></option>
                                    @endforeach
                                </datalist>
                                <small class="text-muted">Start typing and select your country from the suggestions, or
                                    type it manually.</small>
                                @error('country_of_residence')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="consult-card__divider"></div>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase text-2 fw-semibold"
                                        for="consultation_hours">Consultation Hours</label>
                                    <input type="number" class="form-control form-control-lg" id="consultation_hours"
                                        name="consultation_hours" min="1" max="4"
                                        value="{{ old('consultation_hours', $selectedHours) }}" step="1" required>
                                    <small class="text-muted d-block mt-1">You can request up to 4 hours per session.</small>
                                    @error('consultation_hours')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="consult-summary h-100">
                                        <span class="text-uppercase text-2 fw-semibold text-muted d-block">Estimated
                                            Investment</span>
                                        <p class="h3 mb-1 fw-bold text-dark">
                                            $<span id="consultation-total">{{ $initialTotal }}</span>
                                        </p>
                                        <small class="text-muted d-block mt-1">Calculated at $50 per hour. Final payment is made on
                                            the next step.</small>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="selected_date" id="selected_date"
                                value="{{ $selectedDate }}">
                            <input type="hidden" name="rebook_of" value="{{ $rebook_of }}">

                            <div class="mb-4">
                                <label class="form-label text-uppercase text-2 fw-semibold d-block mb-2"
                                    for="consultation_interest">Please Specify Your Consultation Interest</label>
                                <textarea class="form-control form-control-lg" id="consultation_interest"
                                    name="consultation_interest" rows="4" placeholder="Tell us what you'd like to discuss during your consultation..."
                                    maxlength="1000">{{ old('consultation_interest') }}</textarea>
                                <small class="text-muted d-block mt-1">Share your specific interests, questions, or goals. This helps us prepare better for your consultation (Max 1000 characters).</small>
                                @error('consultation_interest')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-warning d-flex align-items-start gap-2 rounded-3 mt-4 mb-3 small">
                                <i class="fas fa-info-circle text-secondary mt-1"></i>
                                <div>
                                    <strong>Heads up!</strong> Select an available date on the calendar before proceeding.
                                    Each day accommodates only two consultations.
                                </div>
                            </div>

                            <div class="d-grid d-sm-flex justify-content-sm-between align-items-center gap-3 mt-4">
                                <div class="selected-date-pill text-muted">
                                    <span class="text-uppercase text-2 fw-semibold d-block">Selected Date</span>
                                    <span id="selected-date-display" class="fw-bold text-dark">{{ $selectedDateFormatted }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-modern px-4 py-3 fw-semibold"
                                    id="begin-payment" disabled>
                                    Proceed to Secure Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-5 col-xxl-5">
                <div class="consult-card consult-card--calendar shadow-lg border-0 sticky-lg-top">
                    <div class="consult-card__body p-4 p-xl-5">
                        <h3 class="h5 fw-bold text-dark mb-3">Reserve a Slot</h3>
                        <p class="text-muted small mb-4">Pick a day that works for you. Dates in our brand crimson are fully
                            booked, while amber indicates one slot left.</p>

                        <div id="consultation-calendar" class="mb-4"></div>

                        <div class="calendar-legend d-flex flex-wrap gap-3 mb-4">
                            <div class="legend-item">
                                <span class="legend-dot legend-dot--available"></span>
                                <span class="small text-muted">Available</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot legend-dot--limited"></span>
                                <span class="small text-muted">1 slot left</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot legend-dot--full"></span>
                                <span class="small text-muted">Fully booked</span>
                            </div>
                        </div>

                        <div class="calendar-note small text-muted" id="calendar-message">
                            Select a highlighted date to continue.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const hourlyRate = {{ (int) $hourlyRate }};
            const maxDailyCapacity = {{ (int) $dailyCapacity }};
            const rawAvailability = @json($availability);
            const availabilityData = Array.isArray(rawAvailability) ? rawAvailability : [];
            let preselectedDate = @json($selectedDate);
            const hourField = document.getElementById('consultation_hours');
            const totalField = document.getElementById('consultation-total');
            const selectedDateField = document.getElementById('selected_date');
            const selectedDateDisplay = document.getElementById('selected-date-display');
            const calendarMessage = document.getElementById('calendar-message');
            const submitButton = document.getElementById('begin-payment');
            let lastSelectedCell = null;

            const calendarEl = document.getElementById('consultation-calendar');

            async function ensureFullCalendar() {
                if (typeof FullCalendar !== 'undefined' && typeof FullCalendar.Calendar === 'function') {
                    return;
                }

                return new Promise((resolve, reject) => {
                    if (document.querySelector('script[data-fc-fallback="1"]')) {
                        reject(new Error('FullCalendar failed to load.'));
                        return;
                    }

                    const fallbackScript = document.createElement('script');
                    fallbackScript.src = '{{ asset('vendor/fullcalendar/main-5.11.5.min.js') }}';
                    fallbackScript.async = true;
                    fallbackScript.dataset.fcFallback = '1';
                    fallbackScript.onload = () => {
                        if (typeof FullCalendar !== 'undefined' && typeof FullCalendar.Calendar === 'function') {
                            resolve();
                        } else {
                            reject(new Error('FullCalendar fallback did not initialize.'));
                        }
                    };
                    fallbackScript.onerror = () => reject(new Error('FullCalendar fallback failed to load.'));
                    document.head.appendChild(fallbackScript);
                });
            }

            try {
                await ensureFullCalendar();
            } catch (error) {
                if (calendarMessage) {
                    calendarMessage.textContent =
                        'We could not load the booking calendar. Please refresh and try again, or contact support.';
                    calendarMessage.classList.add('text-danger');
                }
                console.error(error);
                return;
            }

            const fcReady = typeof FullCalendar !== 'undefined' && typeof FullCalendar.Calendar === 'function';
            if (!fcReady || !calendarEl) {
                if (calendarMessage) {
                    calendarMessage.textContent =
                        'We could not load the booking calendar. Please refresh and try again, or contact support.';
                    calendarMessage.classList.add('text-danger');
                }
                return;
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const todayStr = today.toISOString().split('T')[0];

            function isPastDate(dateStr) {
                const date = new Date(`${dateStr}T00:00:00`);
                return date.getTime() < today.getTime();
            }

            if (preselectedDate && isPastDate(preselectedDate)) {
                preselectedDate = null;
                selectedDateField.value = '';
                selectedDateDisplay.textContent = 'None yet';
            }

            const availabilityMap = availabilityData.reduce((acc, entry) => {
                acc[entry.date] = entry.booked;
                return acc;
            }, {});

            function getStatusForDate(dateStr) {
                if (isPastDate(dateStr)) {
                    return 'past';
                }
                const bookedCount = availabilityMap[dateStr] ?? 0;
                if (bookedCount >= maxDailyCapacity) {
                    return 'full';
                }
                if (bookedCount === maxDailyCapacity - 1) {
                    return 'limited';
                }
                return 'available';
            }

            function setSelectedDate(dateStr, dayElement = null) {
                if (dateStr && isPastDate(dateStr)) {
                    calendarMessage.textContent = 'Past dates cannot be selected.';
                    calendarMessage.classList.add('text-danger');
                    submitButton.disabled = true;
                    return;
                }

                selectedDateField.value = dateStr;
                if (typeof FullCalendar !== 'undefined' && dateStr) {
                    selectedDateDisplay.textContent = FullCalendar.formatDate(new Date(`${dateStr}T00:00:00`), {
                        weekday: 'long',
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric',
                    });
                } else if (dateStr) {
                    const fallbackDate = new Date(`${dateStr}T00:00:00`);
                    if (!Number.isNaN(fallbackDate.getTime())) {
                        selectedDateDisplay.textContent = fallbackDate.toLocaleDateString(undefined, {
                            weekday: 'long',
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric',
                        });
                    } else {
                        selectedDateDisplay.textContent = dateStr;
                    }
                } else {
                    selectedDateDisplay.textContent = 'None yet';
                }

                if (lastSelectedCell) {
                    lastSelectedCell.classList.remove('consult-calendar__selected');
                }
                if (dayElement) {
                    dayElement.classList.add('consult-calendar__selected');
                    lastSelectedCell = dayElement;
                }
                
                // Enable button when a valid date is selected
                if (dateStr) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            }

            if (preselectedDate) {
                setSelectedDate(preselectedDate);
            }

            if (typeof FullCalendar !== 'undefined' && calendarEl) {
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    fixedWeekCount: false,
                    selectable: true,
                    validRange: {
                        start: todayStr
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },
                    dateClick(info) {
                        if (isPastDate(info.dateStr)) {
                            calendarMessage.textContent = 'Past dates cannot be selected.';
                            calendarMessage.classList.add('text-danger');
                            return;
                        }
                        const status = getStatusForDate(info.dateStr);
                        if (status === 'full') {
                            calendarMessage.textContent = 'That day is fully booked. Please choose another date.';
                            calendarMessage.classList.add('text-danger');
                            return;
                        }
                        calendarMessage.textContent = 'Great! Your consultation will be scheduled for the selected date.';
                        calendarMessage.classList.remove('text-danger');

                        setSelectedDate(info.dateStr, info.dayEl);
                    },
                    dayCellDidMount(arg) {
                        const dateStr = arg.date.toISOString().split('T')[0];
                        const status = getStatusForDate(dateStr);
                        arg.el.classList.add(`consult-calendar__${status}`);

                        if (status === 'past') {
                            arg.el.classList.add('consult-calendar__disabled');
                        }

                        if (status === 'full') {
                            arg.el.setAttribute('data-status', 'Fully booked');
                        } else if (status === 'limited') {
                            arg.el.setAttribute('data-status', '1 slot left');
                        } else if (status === 'past') {
                            arg.el.setAttribute('data-status', 'Unavailable');
                        } else {
                            arg.el.setAttribute('data-status', 'Available');
                        }

                        if (preselectedDate && preselectedDate === dateStr) {
                            setSelectedDate(dateStr, arg.el);
                        }
                    }
                });

                calendar.render();

                if (preselectedDate) {
                    setSelectedDate(preselectedDate);
                }
            }

            function updateTotal() {
                const hours = Math.min(Math.max(parseInt(hourField.value || '1', 10), parseInt(hourField.min, 10)),
                    parseInt(hourField.max, 10));
                hourField.value = hours;
                totalField.textContent = (hours * hourlyRate).toFixed(2);
            }

            hourField.addEventListener('input', updateTotal);
            hourField.addEventListener('change', updateTotal);
            updateTotal();

            submitButton.addEventListener('click', function (event) {
                if (!selectedDateField.value) {
                    event.preventDefault();
                    calendarMessage.textContent = 'Please choose an available date before continuing to payment.';
                    calendarMessage.classList.add('text-danger');
                    submitButton.disabled = true;
                } else {
                    calendarMessage.textContent = 'Great! Your consultation will be scheduled for the selected date.';
                    calendarMessage.classList.remove('text-danger');
                    submitButton.disabled = false;
                }
            });
        });
    </script>
@endsection

