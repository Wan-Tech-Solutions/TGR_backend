<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px;">
        <div style="background-color: white; padding: 30px; border-radius: 8px;">
            <!-- Email Body -->
            <div style="margin-bottom: 30px;">
                {!! nl2br(e($body)) !!}
            </div>

            <!-- Signature -->
            <div style="border-top: 1px solid #e0e0e0; padding-top: 20px; margin-top: 30px;">
                <p style="margin: 0 0 5px 0; font-weight: bold;">TGR Africa</p>
                <p style="margin: 0;">Transforming Growth, Realizing Potential</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; font-size: 12px; color: #999;">
            <p style="margin: 5px 0;">This email was sent from TGR Africa Admin Portal</p>
            <p style="margin: 5px 0;">© {{ date('Y') }} TGR Africa. All rights reserved.</p>
        </div>
    </div>
</div>
