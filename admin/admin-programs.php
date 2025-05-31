<?php
$ac_programs = "active";
require_once __DIR__ .'/template/header.php';

?>


<link rel="stylesheet" href="CSS/admin-programs.css">



<div class="content">
            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في الجدول...">
                </div>
                <button class="add-btn" id="openScheduleModal">
                    <i class="fas fa-plus"></i> إضافة موعد جديد
                </button>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="number blue">126</div>
                    <div class="label">إجمالي المواعيد الأسبوعية</div>
                </div>
                <div class="stat-card">
                    <div class="number green">18</div>
                    <div class="label">الحلقات النشطة</div>
                </div>
                <div class="stat-card">
                    <div class="number orange">85%</div>
                    <div class="label">معدل استغلال القاعات</div>
                </div>
                <div class="stat-card">
                    <div class="number red">3</div>
                    <div class="label">تعارضات في المواعيد</div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-title">تصفية الجدول</div>
                <div class="filter-options">
                    <div class="filter-option">
                        <label>نوع الحلقة:</label>
                        <select class="filter-select" id="typeFilter">
                            <option value="all">الكل</option>
                            <option value="quran">حلقات القرآن</option>
                            <option value="hadith">حلقات الحديث</option>
                            <option value="fiqh">حلقات الفقه</option>
                            <option value="tafsir">حلقات التفسير</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>القاعة:</label>
                        <select class="filter-select" id="roomFilter">
                            <option value="all">الكل</option>
                            <option value="1">قاعة 1</option>
                            <option value="2">قاعة 2</option>
                            <option value="3">قاعة 3</option>
                            <option value="4">قاعة 4</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الأستاذ:</label>
                        <select class="filter-select" id="teacherFilter">
                            <option value="all">الكل</option>
                            <option value="1">أ. محمد عبد الرحمن</option>
                            <option value="2">أ. أحمد علي</option>
                            <option value="3">أ. خالد محمود</option>
                            <option value="4">أ. عبد الله سعيد</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="conflict-alert" id="conflictAlert">
                <i class="fas fa-exclamation-triangle"></i>
                تم اكتشاف تعارض في المواعيد! يرجى مراجعة الجدول وحل التعارضات.
            </div>

            <div class="admin-section">
                <div class="section-title">
                    الجدول الأسبوعي للحلقات
                    <span>الأسبوع الحالي</span>
                </div>

                <div class="schedule-legend">
                    <div class="legend-item">
                        <div class="legend-color quran"></div>
                        <span>حلقات القرآن</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color hadith"></div>
                        <span>حلقات الحديث</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color fiqh"></div>
                        <span>حلقات الفقه</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color tafsir"></div>
                        <span>حلقات التفسير</span>
                    </div>
                </div>

                <div class="tabs">
                    <div class="tab active" data-week="current">الأسبوع الحالي</div>
                    <div class="tab" data-week="next">الأسبوع القادم</div>
                    <div class="tab" data-week="month">عرض شهري</div>
                </div>

                <div class="weekly-schedule" id="weeklySchedule">
                    <div class="schedule-header">الوقت</div>
                    <div class="schedule-header">السبت</div>
                    <div class="schedule-header">الأحد</div>
                    <div class="schedule-header">الإثنين</div>
                    <div class="schedule-header">الثلاثاء</div>
                    <div class="schedule-header">الأربعاء</div>
                    <div class="schedule-header">الخميس</div>
                    <div class="schedule-header">الجمعة</div>

                    <!-- 8:00 AM Row -->
                    <div class="time-slot">8:00 ص</div>
                    <div class="schedule-cell" data-time="08:00" data-day="saturday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="08:00" data-day="sunday">
                        <div class="session-block hadith">
                            <div class="session-name">حلقة الحديث 1</div>
                            <div class="session-teacher">أ. خالد محمود</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="08:00" data-day="monday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="08:00" data-day="tuesday">
                        <div class="session-block hadith">
                            <div class="session-name">حلقة الحديث 2</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 2</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="08:00" data-day="wednesday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                        <div class="session-block fiqh">
                            <div class="session-name">حلقة الفقه 1</div>
                            <div class="session-teacher">أ. عبد الله سعيد</div>
                            <div class="session-room">قاعة 4</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="08:00" data-day="thursday"></div>
                    <div class="schedule-cell" data-time="08:00" data-day="friday"></div>

                    <!-- 10:00 AM Row -->
                    <div class="time-slot">10:00 ص</div>
                    <div class="schedule-cell" data-time="10:00" data-day="saturday">
                        <div class="session-block fiqh">
                            <div class="session-name">حلقة الفقه 2</div>
                            <div class="session-teacher">أ. عبد الله سعيد</div>
                            <div class="session-room">قاعة 2</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="10:00" data-day="sunday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 2</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="10:00" data-day="monday"></div>
                    <div class="schedule-cell" data-time="10:00" data-day="tuesday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 2</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="10:00" data-day="wednesday"></div>
                    <div class="schedule-cell" data-time="10:00" data-day="thursday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 2</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                        <div class="session-block tafsir">
                            <div class="session-name">حلقة التفسير 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="10:00" data-day="friday"></div>

                    <!-- 2:00 PM Row -->
                    <div class="time-slot">2:00 م</div>
                    <div class="schedule-cell" data-time="14:00" data-day="saturday"></div>
                    <div class="schedule-cell" data-time="14:00" data-day="sunday">
                        <div class="session-block fiqh">
                            <div class="session-name">حلقة الفقه 1</div>
                            <div class="session-teacher">أ. عبد الله سعيد</div>
                            <div class="session-room">قاعة 4</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="14:00" data-day="monday">
                        <div class="session-block tafsir">
                            <div class="session-name">حلقة التفسير 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="14:00" data-day="tuesday"></div>
                    <div class="schedule-cell" data-time="14:00" data-day="wednesday">
                        <div class="session-block fiqh">
                            <div class="session-name">حلقة الفقه 1</div>
                            <div class="session-teacher">أ. عبد الله سعيد</div>
                            <div class="session-room">قاعة 4</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="14:00" data-day="thursday">
                        <div class="session-block tafsir">
                            <div class="session-name">حلقة التفسير 1</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="14:00" data-day="friday"></div>
                    
                    <!-- 4:00 PM Row -->
                    <div class="time-slot">4:00 م</div>
                    <div class="schedule-cell" data-time="16:00" data-day="saturday">
                        <div class="session-block hadith">
                            <div class="session-name">حلقة الحديث 3</div>
                            <div class="session-teacher">أ. خالد محمود</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="16:00" data-day="sunday"></div>
                    <div class="schedule-cell" data-time="16:00" data-day="monday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 3</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 2</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="16:00" data-day="tuesday">
                        <div class="session-block hadith">
                            <div class="session-name">حلقة الحديث 3</div>
                            <div class="session-teacher">أ. خالد محمود</div>
                            <div class="session-room">قاعة 1</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="16:00" data-day="wednesday"></div>
                    <div class="schedule-cell" data-time="16:00" data-day="thursday">
                        <div class="session-block quran">
                            <div class="session-name">حلقة القرآن 3</div>
                            <div class="session-teacher">أ. أحمد علي</div>
                            <div class="session-room">قاعة 2</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="16:00" data-day="friday"></div>
                    
                    <!-- 6:00 PM Row -->
                    <div class="time-slot">6:00 م</div>
                    <div class="schedule-cell" data-time="18:00" data-day="saturday"></div>
                    <div class="schedule-cell" data-time="18:00" data-day="sunday">
                        <div class="session-block tafsir">
                            <div class="session-name">حلقة التفسير 2</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="18:00" data-day="monday"></div>
                    <div class="schedule-cell" data-time="18:00" data-day="tuesday">
                        <div class="session-block fiqh">
                            <div class="session-name">حلقة الفقه 3</div>
                            <div class="session-teacher">أ. عبد الله سعيد</div>
                            <div class="session-room">قاعة 4</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="18:00" data-day="wednesday">
                        <div class="session-block tafsir">
                            <div class="session-name">حلقة التفسير 2</div>
                            <div class="session-teacher">أ. محمد عبد الرحمن</div>
                            <div class="session-room">قاعة 3</div>
                        </div>
                    </div>
                    <div class="schedule-cell" data-time="18:00" data-day="thursday"></div>
                    <div class="schedule-cell" data-time="18:00" data-day="friday"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding New Schedule -->
    <div class="modal" id="scheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">إضافة موعد جديد للحلقة</div>
                <button class="close-btn" id="closeScheduleModal">&times;</button>
            </div>
            <form id="scheduleForm">
                <div class="form-group">
                    <label class="form-label">اليوم</label>
                    <select class="form-input" id="scheduleDay" required>
                        <option value="saturday">السبت</option>
                        <option value="sunday">الأحد</option>
                        <option value="monday">الإثنين</option>
                        <option value="tuesday">الثلاثاء</option>
                        <option value="wednesday">الأربعاء</option>
                        <option value="thursday">الخميس</option>
                        <option value="friday">الجمعة</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">الوقت</label>
                    <select class="form-input" id="scheduleTime" required>
                        <option value="08:00">8:00 ص</option>
                        <option value="10:00">10:00 ص</option>
                        <option value="12:00">12:00 م</option>
                        <option value="14:00">2:00 م</option>
                        <option value="16:00">4:00 م</option>
                        <option value="18:00">6:00 م</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">نوع الحلقة</label>
                    <select class="form-input" id="sessionType" required>
                        <option value="quran">حلقة قرآن</option>
                        <option value="hadith">حلقة حديث</option>
                        <option value="fiqh">حلقة فقه</option>
                        <option value="tafsir">حلقة تفسير</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">اسم الحلقة</label>
                    <input type="text" class="form-input" id="sessionName" placeholder="أدخل اسم الحلقة" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الأستاذ</label>
                    <select class="form-input" id="sessionTeacher" required>
                        <option value="أ. محمد عبد الرحمن">أ. محمد عبد الرحمن</option>
                        <option value="أ. أحمد علي">أ. أحمد علي</option>
                        <option value="أ. خالد محمود">أ. خالد محمود</option>
                        <option value="أ. عبد الله سعيد">أ. عبد الله سعيد</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">القاعة</label>
                    <select class="form-input" id="sessionRoom" required>
                        <option value="قاعة 1">قاعة 1</option>
                        <option value="قاعة 2">قاعة 2</option>
                        <option value="قاعة 3">قاعة 3</option>
                        <option value="قاعة 4">قاعة 4</option>
                    </select>
                </div>
                <button type="submit" class="form-submit">إضافة الموعد</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal handling
            const scheduleModal = document.getElementById('scheduleModal');
            const openScheduleModalBtn = document.getElementById('openScheduleModal');
            const closeScheduleModalBtn = document.getElementById('closeScheduleModal');
            const scheduleForm = document.getElementById('scheduleForm');
            const conflictAlert = document.getElementById('conflictAlert');
            
            // Open modal
            openScheduleModalBtn.addEventListener('click', function() {
                scheduleModal.style.display = 'flex';
            });
            
            // Close modal
            closeScheduleModalBtn.addEventListener('click', function() {
                scheduleModal.style.display = 'none';
            });
            
            // Click outside to close
            window.addEventListener('click', function(event) {
                if (event.target === scheduleModal) {
                    scheduleModal.style.display = 'none';
                }
            });
            
            // Form submission
            scheduleForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const day = document.getElementById('scheduleDay').value;
                const time = document.getElementById('scheduleTime').value;
                const type = document.getElementById('sessionType').value;
                const name = document.getElementById('sessionName').value;
                const teacher = document.getElementById('sessionTeacher').value;
                const room = document.getElementById('sessionRoom').value;
                
                // Find the target cell
                const targetCell = document.querySelector(`.schedule-cell[data-day="${day}"][data-time="${time}"]`);
                
                // Check for conflicts (simplified)
                const cellContents = targetCell.innerHTML.trim();
                if (cellContents && cellContents.includes('session-block')) {
                    // Show conflict alert
                    conflictAlert.classList.add('show');
                    setTimeout(() => {
                        conflictAlert.classList.remove('show');
                    }, 5000);
                    return;
                }
                
                // Create new session block
                const sessionBlock = document.createElement('div');
                sessionBlock.className = `session-block ${type}`;
                sessionBlock.innerHTML = `
                    <div class="session-name">${name}</div>
                    <div class="session-teacher">${teacher}</div>
                    <div class="session-room">${room}</div>
                `;
                
                // Add to schedule
                targetCell.appendChild(sessionBlock);
                
                // Close modal and reset form
                scheduleModal.style.display = 'none';
                scheduleForm.reset();
            });
            
            // Tab switching
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Here you would load different schedule data based on the selected tab
                    // For demo purposes, we'll just show a console message
                    console.log(`Switching to ${this.dataset.week} week view`);
                });
            });
            
            // Filter functionality
            const typeFilter = document.getElementById('typeFilter');
            const roomFilter = document.getElementById('roomFilter');
            const teacherFilter = document.getElementById('teacherFilter');
            
            // Combined filter function
            function applyFilters() {
                const typeValue = typeFilter.value;
                const roomValue = roomFilter.value;
                const teacherValue = teacherFilter.value;
                
                // Get all session blocks
                const sessionBlocks = document.querySelectorAll('.session-block');
                
                sessionBlocks.forEach(block => {
                    // Reset visibility
                    block.style.display = 'block';
                    
                    // Apply type filter
                    if (typeValue !== 'all' && !block.classList.contains(typeValue)) {
                        block.style.display = 'none';
                        return;
                    }
                    
                    // Apply room filter
                    if (roomValue !== 'all') {
                        const roomText = block.querySelector('.session-room').textContent;
                        if (!roomText.includes(`قاعة ${roomValue}`)) {
                            block.style.display = 'none';
                            return;
                        }
                    }
                    
                    // Apply teacher filter
                    if (teacherValue !== 'all') {
                        const teacherText = block.querySelector('.session-teacher').textContent;
                        // This is a simplified check - in a real app you'd have teacher IDs
                        if (teacherValue === '1' && !teacherText.includes('محمد عبد الرحمن')) {
                            block.style.display = 'none';
                        } else if (teacherValue === '2' && !teacherText.includes('أحمد علي')) {
                            block.style.display = 'none';
                        } else if (teacherValue === '3' && !teacherText.includes('خالد محمود')) {
                            block.style.display = 'none';
                        } else if (teacherValue === '4' && !teacherText.includes('عبد الله سعيد')) {
                            block.style.display = 'none';
                        }
                    }
                });
            }
            
            // Add event listeners to filters
            typeFilter.addEventListener('change', applyFilters);
            roomFilter.addEventListener('change', applyFilters);
            teacherFilter.addEventListener('change', applyFilters);
            
            // Cell click for editing (simplified)
            const scheduleCells = document.querySelectorAll('.schedule-cell');
            scheduleCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    const blocks = this.querySelectorAll('.session-block');
                    if (blocks.length > 0) {
                        // For simplicity, just log the info - in a real app you'd open an edit modal
                        console.log(`Clicked cell: ${this.dataset.day} at ${this.dataset.time}`);
                        blocks.forEach(block => {
                            const name = block.querySelector('.session-name').textContent;
                            console.log(`Session: ${name}`);
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>