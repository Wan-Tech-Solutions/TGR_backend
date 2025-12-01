@component('mail::message')
# New Consultation Booking

Hi Admin,

A new consultation has been booked! Here are the details:

**Booking Information:**
- **Name:** {{ $consultation->name }}
- **Email:** {{ $consultation->email }}
- **Phone:** {{ $consultation->dial_code }}{{ $consultation->phone }}
- **Nationality:** {{ $consultation->nationality ?? 'Not specified' }}
- **Country of Residence:** {{ $consultation->country_of_residence ?? 'Not specified' }}

**Consultation Details:**
- **Reference:** {{ $consultation->reference }}
- **Scheduled Date:** {{ $consultation->scheduled_for?->format('F j, Y') ?? 'Not scheduled' }}
- **Duration:** {{ $consultation->consultation_hours }} hour(s)
- **Interest:** {{ $consultation->consultation_interest ?? 'Not specified' }}
- **Amount:** ${{ number_format($consultation->quoted_amount / 100, 2) }}

**Payment Status:** {{ ucfirst($consultation->payment_status) }}
**Booking Status:** {{ ucfirst($consultation->status) }}

@component('mail::button', ['url' => route('admin.consultations.show', $consultation)])
View Consultation
@endcomponent

Please review this booking and take appropriate action.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
