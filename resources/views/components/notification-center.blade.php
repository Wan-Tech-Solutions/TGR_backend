<!-- Notification Toast Container -->
<div id="notificationToastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <!-- Toasts will be inserted here dynamically -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationSystem = {
        baseUrl: '/admin-notifications',
        pollInterval: 5000, // Poll every 5 seconds
        toastTemplate: `
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-notification-id="{id}">
                <div class="toast-header bg-{color} text-white">
                    <i class="fas {icon} me-2"></i>
                    <strong class="me-auto">{title}</strong>
                    <small>{time}</small>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {message}
                    {actionButton}
                </div>
            </div>
        `,

        init: function() {
            this.setupEventListeners();
            this.checkNotifications();
            setInterval(() => this.checkNotifications(), this.pollInterval);
        },

        setupEventListeners: function() {
            // Mark all as read when dropdown is opened
            const notifDropdown = document.getElementById('notifDropdown');
            if (notifDropdown) {
                notifDropdown.addEventListener('click', () => {
                    // Mark all as read when opening dropdown
                    setTimeout(() => this.markAllAsRead(), 100);
                });
            }

            // Mark all as read button
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', () => this.markAllAsRead());
            }
        },

        checkNotifications: function() {
            fetch(`${this.baseUrl}/unread`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.notifications && data.notifications.length > 0) {
                        this.updateBadge(data.count);
                        this.updateDropdownContent(data.notifications);
                        data.notifications.forEach(notification => {
                            this.showToast(notification);
                        });
                    }
                })
                .catch(error => console.error('Notification check failed:', error));
        },

        updateBadge: function(count) {
            const notifLink = document.getElementById('notifDropdown');
            if (!notifLink) return;

            // Update bell icon badge
            let badgeElement = notifLink.querySelector('.notification');
            
            if (count > 0) {
                if (!badgeElement) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notification';
                    newBadge.textContent = count > 99 ? '99+' : count;
                    notifLink.appendChild(newBadge);
                } else {
                    badgeElement.textContent = count > 99 ? '99+' : count;
                }
            } else if (badgeElement) {
                badgeElement.remove();
            }

            // Update title badge
            const titleBadge = document.querySelector('.dropdown-title .badge-warning');
            if (titleBadge) {
                if (count > 0) {
                    titleBadge.textContent = count;
                    titleBadge.style.display = 'inline-block';
                } else {
                    titleBadge.style.display = 'none';
                }
            }
        },

        updateDropdownContent: function(notifications) {
            const notifCenter = document.querySelector('.notif-center');
            if (!notifCenter) return;

            if (notifications.length === 0) {
                notifCenter.innerHTML = `
                    <div class="notif-item simpler-notif text-center py-3">
                        <span class="text-muted">No new notifications</span>
                    </div>
                `;
                return;
            }

            let html = '';
            notifications.forEach(notification => {
                let actionLink = '';
                if (notification.related_type === 'Consultation' && notification.related_id) {
                    actionLink = `<a href="/admin-consultations/${notification.related_id}" class="mt-2 btn btn-sm btn-primary" style="display:block; width:100%; text-align:center;">View Consultation</a>`;
                }

                html += `
                    <div class="notif-item simpler-notif" data-notification-id="${notification.id}" style="padding: 12px; border-bottom: 1px solid #f3f3f3;">
                        <div class="notif-text" style="display: flex; flex-direction: column; gap: 4px;">
                            <span class="block" style="font-weight: 600; color: #333;"><strong>${notification.title}</strong></span>
                            <span class="block" style="color: #666; font-size: 13px;">${notification.message}</span>
                            <span class="time" style="color: #999; font-size: 11px;">${notification.created_at}</span>
                            ${actionLink}
                        </div>
                    </div>
                `;
            });

            notifCenter.innerHTML = html;
        },

        showToast: function(notification) {
            const container = document.getElementById('notificationToastContainer');
            const timeAgo = notification.created_at;
            
            let actionButton = '';
            if (notification.related_type === 'Consultation' && notification.related_id) {
                actionButton = `<div class="mt-3"><a href="/admin-consultations/${notification.related_id}" class="btn btn-sm btn-primary">View Consultation</a></div>`;
            }

            const toastHtml = this.toastTemplate
                .replace('{id}', notification.id)
                .replace('{color}', notification.color)
                .replace('{icon}', notification.icon)
                .replace('{title}', notification.title)
                .replace('{message}', notification.message)
                .replace('{time}', timeAgo)
                .replace('{actionButton}', actionButton);

            const toastElement = document.createElement('div');
            toastElement.innerHTML = toastHtml;
            container.appendChild(toastElement.firstElementChild);

            // Initialize Bootstrap toast
            const toast = new bootstrap.Toast(toastElement.querySelector('.toast'));
            toast.show();

            // Remove toast element after it's hidden
            toastElement.querySelector('.toast').addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        },

        markAsRead: function(notificationId) {
            fetch(`${this.baseUrl}/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.checkNotifications();
                }
            })
            .catch(error => console.error('Failed to mark notification as read:', error));
        },

        markAllAsRead: function() {
            fetch(`${this.baseUrl}/mark-all-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.checkNotifications();
                }
            })
            .catch(error => console.error('Failed to mark all as read:', error));
        },

        deleteNotification: function(notificationId) {
            if (confirm('Delete this notification?')) {
                fetch(`${this.baseUrl}/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.checkNotifications();
                    }
                })
                .catch(error => console.error('Failed to delete notification:', error));
            }
        }
    };

    // Initialize notification system
    notificationSystem.init();
    
    // Make available globally for button clicks
    window.notificationSystem = notificationSystem;
});
</script>

<style>
.toast-header {
    border-radius: 0.5rem 0.5rem 0 0;
}

.toast-body {
    padding: 1rem;
}

.notification {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: bold;
}

.notif-item {
    transition: background-color 0.2s ease;
}

.notif-item:hover {
    background-color: #f8f9fa !important;
}
</style>
