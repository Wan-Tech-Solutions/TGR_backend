<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px;">
        <div style="background-color: white; padding: 30px; border-radius: 8px;">
            <!-- Header -->
            <div style="border-bottom: 3px solid #3b82f6; padding-bottom: 20px; margin-bottom: 30px;">
                <h1 style="margin: 0; color: #1f2937; font-size: 24px;">Consultation Booking Confirmed!</h1>
                <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 14px;">Reference: {{ $consultation->reference }}</p>
            </div>

            <!-- Welcome Message -->
            <div style="margin-bottom: 30px;">
                <p style="margin: 0 0 15px 0; font-size: 14px;">Dear {{ $consultation->name }},</p>
                <p style="margin: 0 0 15px 0; color: #555;">Thank you for booking a consultation with TGR Africa! We're excited to work with you. Your consultation has been successfully scheduled and is awaiting payment confirmation.</p>
            </div>

            <!-- Consultation Details -->
            <div style="background-color: #f9fafb; border-left: 4px solid #3b82f6; padding: 20px; margin-bottom: 30px; border-radius: 4px;">
                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">📋 Consultation Details</h3>
                
                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Reference Number</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937; font-weight: bold;">{{ $consultation->reference }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Scheduled Date</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->scheduled_for->format('l, F j, Y') }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Consultation Duration</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->consultation_hours }} {{ $consultation->consultation_hours == 1 ? 'Hour' : 'Hours' }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Quoted Amount</p>
                    <p style="margin: 5px 0 0 0; font-size: 16px; color: #059669; font-weight: bold;">USD ${{ number_format($consultation->quoted_amount / 100, 2) }}</p>
                </div>

                <div>
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Status</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">
                        <span style="background-color: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                            Pending Payment
                        </span>
                    </p>
                </div>
            </div>

            <!-- Client Information -->
            <div style="background-color: #f9fafb; border-left: 4px solid #8b5cf6; padding: 20px; margin-bottom: 30px; border-radius: 4px;">
                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">👤 Your Information</h3>
                
                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Name</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->name }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Email</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->email }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Phone</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->dial_code }} {{ $consultation->phone }}</p>
                </div>

                <div style="margin-bottom: 12px;">
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Nationality</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->nationality ?? 'Not specified' }}</p>
                </div>

                <div>
                    <p style="margin: 0; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold;">Country of Residence</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #1f2937;">{{ $consultation->country_of_residence }}</p>
                </div>
            </div>

            <!-- Next Steps -->
            <div style="background-color: #dbeafe; border-left: 4px solid #3b82f6; padding: 20px; margin-bottom: 30px; border-radius: 4px;">
                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">📌 Next Steps</h3>
                <ol style="margin: 0; padding-left: 20px; color: #555;">
                    <li style="margin-bottom: 10px;">Complete your payment to confirm the booking</li>
                    <li style="margin-bottom: 10px;">You will receive a confirmation email once payment is processed</li>
                    <li style="margin-bottom: 10px;">A consultation link will be sent 24 hours before your scheduled time</li>
                    <li>Our team will reach out to confirm your preferred meeting method</li>
                </ol>
            </div>

            <!-- Payment Note -->
            <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 20px; margin-bottom: 30px; border-radius: 4px;">
                <p style="margin: 0; color: #7f1d1d; font-weight: bold;">⚠️ Important: Payment Required</p>
                <p style="margin: 10px 0 0 0; color: #991b1b; font-size: 14px;">Your consultation booking is not complete until payment is received. Please complete your payment to secure your consultation slot.</p>
            </div>

            <!-- Contact Support -->
            <div style="margin-bottom: 30px;">
                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">🆘 Need Help?</h3>
                <p style="margin: 0 0 10px 0; color: #555;">If you have any questions or need to reschedule, please don't hesitate to contact us:</p>
                <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #555;">
                    <li style="margin-bottom: 5px;">Email: <a href="mailto:info@tgrafrica.com" style="color: #3b82f6; text-decoration: none;">info@tgrafrica.com</a></li>
                    <li>Phone: <a href="tel:+1234567890" style="color: #3b82f6; text-decoration: none;">+233 500-200-335</a></li>
                </ul>
            </div>

            <!-- Closing -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <p style="margin: 0 0 10px 0; color: #555;">Best regards,</p>
                <p style="margin: 0; font-weight: bold; color: #1f2937;">The TGR Africa Team</p>
                <p style="margin: 10px 0 0 0; color: #6b7280; font-size: 12px;">Transforming Growth, Realizing Potential</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; font-size: 12px; color: #999;">
            <p style="margin: 5px 0;">© {{ date('Y') }} TGR Africa. All rights reserved.</p>
            <p style="margin: 5px 0;">This is an automated confirmation email. Please do not reply to this email.</p>
        </div>
    </div>
</div>
