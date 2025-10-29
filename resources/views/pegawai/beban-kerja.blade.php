@extends('layouts.pegawai')

@section('title', 'Beban Kerja')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>Tambah Entri Beban Kerja
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pegawai.beban-kerja') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="task_id" class="form-label">
                                <i class="fas fa-tasks me-2"></i>Uraian Tugas
                            </label>
                            
                            <!-- Google-like Searchable Task Selection -->
                            <div class="searchable-select-container">
                                <div class="search-input-wrapper">
                                    <input type="text" 
                                           class="form-control search-input @error('task_id') is-invalid @enderror" 
                                           id="task-search-input" 
                                           placeholder="🔍 Klik disini untuk memilih dari daftar..."
                                           autocomplete="off"
                                           value="">
                                    <div class="clear-icon" id="clear-search" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                                
                                <!-- Dropdown Results will be dynamically created -->
                                
                                <!-- Hidden input for form submission -->
                                <input type="hidden" 
                                       id="task_id" 
                                       name="task_id" 
                                       value="{{ old('task_id') }}"
                                       required>
                            </div>
                            
                            @error('task_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock me-2"></i>Jenis Tugas
                            </label>
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label small fw-bold">Harian</label>
                                    <input type="number" 
                                           class="form-control time-unit-input @error('quantity_daily') is-invalid @enderror" 
                                           id="quantity_daily"
                                           name="quantity_daily" 
                                           value="{{ old('quantity_daily') }}" 
                                           min="0"
                                           placeholder="0"
                                           data-unit="daily">
                                </div>
                                <div class="col-3">
                                    <label class="form-label small fw-bold">Mingguan</label>
                                    <input type="number" 
                                           class="form-control time-unit-input @error('quantity_weekly') is-invalid @enderror" 
                                           id="quantity_weekly"
                                           name="quantity_weekly" 
                                           value="{{ old('quantity_weekly') }}" 
                                           min="0"
                                           placeholder="0"
                                           data-unit="weekly">
                                </div>
                                <div class="col-3">
                                    <label class="form-label small fw-bold">Bulanan</label>
                                    <input type="number" 
                                           class="form-control time-unit-input @error('quantity_monthly') is-invalid @enderror" 
                                           id="quantity_monthly"
                                           name="quantity_monthly" 
                                           value="{{ old('quantity_monthly') }}" 
                                           min="0"
                                           placeholder="0"
                                           data-unit="monthly">
                                </div>
                                <div class="col-3">
                                    <label class="form-label small fw-bold">Tahunan</label>
                                    <input type="number" 
                                           class="form-control time-unit-input @error('quantity_yearly') is-invalid @enderror" 
                                           id="quantity_yearly"
                                           name="quantity_yearly" 
                                           value="{{ old('quantity_yearly') }}" 
                                           min="0"
                                           placeholder="0"
                                           data-unit="yearly">
                                </div>
                            </div>
                            <small class="text-muted">⚠️ Hanya isi salah satu kolom jenis tugas saja!</small>
                            @error('time_unit')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Hidden inputs untuk quantity dan time_unit -->
                    <input type="hidden" id="quantity" name="quantity" value="{{ old('quantity') }}">
                    <input type="hidden" id="time_unit" name="time_unit" value="{{ old('time_unit') }}">
                    
                    <!-- Preview Hasil Perhitungan - PERMANEN SELALU TAMPIL -->
                    <div class="row" id="preview-container" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                        <div class="col-12 mb-3">
                            <div class="alert alert-secondary mb-0" id="preview-box" style="border-left: 4px solid #6c757d; background-color: #f8f9fa; display: block !important;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="fas fa-calculator me-2 text-secondary" id="preview-icon"></i>
                                        <strong>Hasil Perhitungan:</strong>
                                    </div>
                                    <div class="text-end">
                                        <h3 class="mb-0 text-secondary" id="preview-result">-</h3>
                                        <small class="text-muted" id="preview-detail">Pilih uraian tugas dan isi jenis tugas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Entri
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Entri Beban Kerja -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Entri Beban Kerja
                </h5>
            </div>
            <div class="card-body">
                @if($workloadEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Uraian Tugas</th>
                                    <th colspan="4" class="text-center">Jenis Tugas</th>
                                    <th>Waktu (menit)</th>
                                    <th>Menit kerja per hari</th>
                                    <th>Edit Ke-</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center">Harian</th>
                                    <th class="text-center">Mingguan</th>
                                    <th class="text-center">Bulanan</th>
                                    <th class="text-center">Tahunan</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workloadEntries as $index => $entry)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $entry->task->task_description }}</td>
                                        <td class="text-center">
                                            @if($entry->time_unit === 'daily')
                                                <strong>{{ $entry->quantity }}</strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($entry->time_unit === 'weekly')
                                                <strong>{{ $entry->quantity }}</strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($entry->time_unit === 'monthly')
                                                <strong>{{ $entry->quantity }}</strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($entry->time_unit === 'yearly')
                                                <strong>{{ $entry->quantity }}</strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ number_format($entry->task->time_per_unit * $entry->quantity) }} menit</td>
                                        <td>{{ number_format($entry->calculateMinutesPerDay(), 1) }} menit</td>
                                        <td>
                                            @if($entry->edit_count > 0)
                                                <span class="badge" style="background: linear-gradient(135deg, #f1c40f, #f39c12);">Edit ke-{{ $entry->edit_count }}</span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">Original</span>
                                            @endif
                                        </td>
                                        <td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pegawai.edit-beban-kerja', $entry) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('pegawai.beban-kerja', $entry) }}" 
                                                      class="d-inline btn-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Waktu Kerja per Hari</h6>
                                    @php
                                        $totalMinutesPerDay = $workloadEntries->sum(function($entry) {
                                            return $entry->calculateMinutesPerDay();
                                        });
                                    @endphp
                                    <h4 class="text-primary">{{ number_format($totalMinutesPerDay, 1) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Waktu Kerja Efektif</h6>
                                    <h4 class="text-success">300</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Kelebihan Waktu Kerja</h6>
                                    @php
                                        $excessMinutes = $totalMinutesPerDay - 300;
                                    @endphp
                                    <h4 class="{{ $excessMinutes > 0 ? 'text-danger' : ($excessMinutes < -10 ? 'text-warning' : 'text-success') }}">
                                        {{ $excessMinutes > 0 ? '+' : '' }}{{ number_format($excessMinutes, 1) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada entri beban kerja</h5>
                        <p class="text-muted">Mulai dengan menambahkan entri beban kerja pertama Anda di form di atas.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskSelect = document.getElementById('task_id');
        const timeUnitInputs = document.querySelectorAll('.time-unit-input');
        const quantityHidden = document.getElementById('quantity');
        const timeUnitHidden = document.getElementById('time_unit');
        const searchInput = document.getElementById('task-search-input');
        const clearSearchBtn = document.getElementById('clear-search');
        
        let allTasks = [];
        let filteredTasks = [];
        let searchResults = null;
        
        // Initialize tasks data from server
        const serverTasks = @json($tasks);
        allTasks = serverTasks.map(task => ({
            id: task.id,
            description: task.task_description,
            timePerUnit: task.time_per_unit
        }));
        
        filteredTasks = [...allTasks];
        
        // Create dropdown element dynamically
        function createDropdown() {
            if (searchResults) return searchResults;
            
            searchResults = document.createElement('div');
            searchResults.id = 'search-results';
            searchResults.className = 'search-results';
            searchResults.style.display = 'none';
            
            // Add to body to avoid clipping
            document.body.appendChild(searchResults);
            
            return searchResults;
        }
        
        // Function to filter tasks based on search query
        function filterTasks(query) {
            if (!query.trim()) {
                filteredTasks = [...allTasks];
            } else {
                filteredTasks = allTasks.filter(task => 
                    task.description.toLowerCase().includes(query.toLowerCase())
                );
            }
            
            // Update UI
            updateSearchResults();
        }
        
        // Function to update search results display
        function updateSearchResults() {
            const dropdown = createDropdown();
            
            // Create header
            const header = document.createElement('div');
            header.className = 'search-results-header';
            header.innerHTML = `
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Menampilkan ${filteredTasks.length} tugas
                    ${searchInput.value.trim() ? `untuk pencarian "${searchInput.value.trim()}"` : ''}
                </small>
            `;
            
            // Create results list
            const resultsList = document.createElement('div');
            resultsList.className = 'search-results-list';
            
            if (filteredTasks.length === 0) {
                // Show "no results" message
                const noResultsItem = document.createElement('div');
                noResultsItem.className = 'search-result-item no-results';
                noResultsItem.innerHTML = `
                    <div class="task-description text-muted">
                        <i class="fas fa-search me-2"></i>
                        Tidak ada tugas yang cocok dengan pencarian "${searchInput.value.trim()}"
                    </div>
                `;
                resultsList.appendChild(noResultsItem);
            } else {
                // Add filtered results
                filteredTasks.forEach(task => {
                    const resultItem = document.createElement('div');
                    resultItem.className = 'search-result-item';
                    resultItem.dataset.taskId = task.id;
                    resultItem.dataset.taskDescription = task.description;
                    resultItem.dataset.timePerUnit = task.timePerUnit;
                    
                    resultItem.innerHTML = `
                        <div class="task-description">${task.description}</div>
                        <div class="task-duration">(${task.timePerUnit} menit/unit)</div>
                    `;
                    
                    // Add click event
                    resultItem.addEventListener('click', function() {
                        selectTask(task.id, task.description, task.timePerUnit);
                    });
                    
                    resultsList.appendChild(resultItem);
                });
            }
            
            // Clear and rebuild dropdown content
            dropdown.innerHTML = '';
            dropdown.appendChild(header);
            dropdown.appendChild(resultsList);
        }
        
        // Function to show all tasks when clicking search field
        function showAllTasks() {
            filteredTasks = [...allTasks];
            updateSearchResults();
            
            const dropdown = createDropdown();
            dropdown.style.display = 'block';
            
            // Position dropdown after a small delay to ensure proper rendering
            setTimeout(() => {
                positionDropdown();
            }, 10);
        }
        
        // Function to position dropdown correctly
        function positionDropdown() {
            const searchInput = document.getElementById('task-search-input');
            const dropdown = createDropdown();
            
            if (!searchInput || !dropdown) return;
            
            const rect = searchInput.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const dropdownHeight = 400; // max-height from CSS
            
            // Calculate position relative to viewport
            let top = rect.bottom + 4;
            let left = rect.left;
            let width = rect.width; // Use only the search input width, not the entire column
            
            // Check if dropdown would go below viewport
            if (rect.bottom + dropdownHeight > viewportHeight) {
                // Position above the input field
                top = rect.top - dropdownHeight - 4;
            }
            
            // Apply positioning
            dropdown.style.position = 'fixed';
            dropdown.style.top = top + 'px';
            dropdown.style.left = left + 'px';
            dropdown.style.width = width + 'px';
            dropdown.style.zIndex = '99999';
            dropdown.style.maxHeight = '400px';
            dropdown.style.maxWidth = '400px'; // Limit maximum width
        }
        
        // Function to select a task
        function selectTask(taskId, taskDescription, timePerUnit) {
            taskSelect.value = taskId;
            searchInput.value = taskDescription;
            
            const dropdown = createDropdown();
            dropdown.style.display = 'none';
            clearSearchBtn.style.display = 'block';
            
            // Trigger change event for calculations
            calculateAndShowPreview();
        }
        
        // Search input event listeners
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query) {
                filterTasks(query);
                const dropdown = createDropdown();
                dropdown.style.display = 'block';
                clearSearchBtn.style.display = 'block';
                
                // Position dropdown after a small delay
                setTimeout(() => {
                    positionDropdown();
                }, 10);
            } else {
                // If input is empty, show all tasks
                showAllTasks();
                clearSearchBtn.style.display = 'none';
                taskSelect.value = '';
            }
        });
        
        searchInput.addEventListener('focus', function() {
            // Show all tasks when focusing on search field
            showAllTasks();
        });
        
        searchInput.addEventListener('click', function() {
            // Show all tasks when clicking on search field
            showAllTasks();
        });
        
        // Clear search functionality
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            taskSelect.value = '';
            
            const dropdown = createDropdown();
            dropdown.style.display = 'none';
            this.style.display = 'none';
            calculateAndShowPreview();
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.searchable-select-container')) {
                const dropdown = createDropdown();
                dropdown.style.display = 'none';
            }
        });
        
        // Reposition dropdown on window resize and scroll
        window.addEventListener('resize', function() {
            const dropdown = createDropdown();
            if (dropdown.style.display === 'block') {
                positionDropdown();
            }
        });
        
        window.addEventListener('scroll', function() {
            const dropdown = createDropdown();
            if (dropdown.style.display === 'block') {
                positionDropdown();
            }
        });
        
        // Function to update preview - ALWAYS VISIBLE, NEVER HIDE
        function updatePreview(minutesPerDay, selectedQuantity, timePerUnit, totalMinutes) {
            const previewContainer = document.getElementById('preview-container');
            const previewBox = document.getElementById('preview-box');
            const previewResult = document.getElementById('preview-result');
            const previewDetail = document.getElementById('preview-detail');
            const previewIcon = document.getElementById('preview-icon');
            
            if (previewContainer && previewBox && previewResult && previewDetail && previewIcon) {
                // FORCE VISIBLE - NEVER HIDE
                previewContainer.style.display = 'block';
                previewContainer.style.visibility = 'visible';
                previewContainer.style.opacity = '1';
                previewBox.style.display = 'block';
                
                // Update to SUCCESS style
                previewBox.className = 'alert alert-success mb-0';
                previewBox.style.borderLeft = '4px solid #28a745';
                previewBox.style.backgroundColor = '#d4edda';
                previewBox.style.display = 'block';
                previewResult.className = 'mb-0 text-success';
                previewIcon.className = 'fas fa-check-circle text-success me-2';
                
                // Update content
                previewResult.textContent = minutesPerDay.toFixed(1) + ' menit/hari';
                previewDetail.textContent = `${selectedQuantity}x × ${timePerUnit} menit = ${totalMinutes} menit`;
            }
        }
        
        // Function to reset preview to default state - STILL VISIBLE, NEVER HIDE
        function resetPreview() {
            const previewContainer = document.getElementById('preview-container');
            const previewBox = document.getElementById('preview-box');
            const previewResult = document.getElementById('preview-result');
            const previewDetail = document.getElementById('preview-detail');
            const previewIcon = document.getElementById('preview-icon');
            
            if (previewContainer && previewBox && previewResult && previewDetail && previewIcon) {
                // FORCE VISIBLE - NEVER HIDE
                previewContainer.style.display = 'block';
                previewContainer.style.visibility = 'visible';
                previewContainer.style.opacity = '1';
                previewBox.style.display = 'block';
                
                // Reset to DEFAULT style
                previewBox.className = 'alert alert-secondary mb-0';
                previewBox.style.borderLeft = '4px solid #6c757d';
                previewBox.style.backgroundColor = '#f8f9fa';
                previewBox.style.display = 'block';
                previewResult.className = 'mb-0 text-secondary';
                previewIcon.className = 'fas fa-calculator me-2 text-secondary';
                
                // Reset content
                previewResult.textContent = '-';
                previewDetail.textContent = 'Pilih uraian tugas dan isi jenis tugas';
            }
        }
        
        // Function to calculate and show preview
        function calculateAndShowPreview() {
            const taskId = taskSelect.value;
            
            // If no task selected, reset preview to default
            if (!taskId) {
                resetPreview();
                return;
            }
            
            // Get task time per unit from data attribute
            const selectedTask = allTasks.find(task => task.id == taskId);
            if (!selectedTask) {
                resetPreview();
                return;
            }
            
            const timePerUnit = selectedTask.timePerUnit;
            
            // Find which time unit has value
            let selectedQuantity = 0;
            let selectedTimeUnit = '';
            
            timeUnitInputs.forEach(input => {
                const value = parseInt(input.value) || 0;
                if (value > 0) {
                    selectedQuantity = value;
                    selectedTimeUnit = input.dataset.unit;
                }
            });
            
            if (selectedQuantity > 0 && selectedTimeUnit) {
                // Update hidden inputs
                quantityHidden.value = selectedQuantity;
                timeUnitHidden.value = selectedTimeUnit;
                
                // Calculate minutes per day
                let minutesPerDay = timePerUnit * selectedQuantity;
                const totalMinutes = minutesPerDay;
                
                switch (selectedTimeUnit) {
                    case 'daily':
                        // Already per day, no division needed
                        break;
                    case 'weekly':
                        minutesPerDay = minutesPerDay / 5;
                        break;
                    case 'monthly':
                        minutesPerDay = minutesPerDay / 20;
                        break;
                    case 'yearly':
                        minutesPerDay = minutesPerDay / 240;
                        break;
                }
                
                // Update preview with calculated result
                updatePreview(minutesPerDay, selectedQuantity, timePerUnit, totalMinutes);
            } else {
                // Clear hidden inputs and reset preview to default
                quantityHidden.value = '';
                timeUnitHidden.value = '';
                resetPreview();
            }
        }
        
        // Event listeners
        taskSelect.addEventListener('change', calculateAndShowPreview);
        
        timeUnitInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Clear other inputs when this one has value
                if (parseInt(this.value) > 0) {
                    timeUnitInputs.forEach(otherInput => {
                        if (otherInput !== this) {
                            otherInput.value = '';
                        }
                    });
                }
                
                // Always update hidden fields immediately
                const selectedQuantity = parseInt(this.value) || 0;
                const selectedTimeUnit = this.dataset.unit;
                
                if (selectedQuantity > 0) {
                    quantityHidden.value = selectedQuantity;
                    timeUnitHidden.value = selectedTimeUnit;
                    console.log('Hidden fields updated:', quantityHidden.value, timeUnitHidden.value);
                } else {
                    quantityHidden.value = '';
                    timeUnitHidden.value = '';
                }
                
                calculateAndShowPreview();
            });
        });
        
        // Form validation before submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const quantityHidden = document.getElementById('quantity');
                const timeUnitHidden = document.getElementById('time_unit');
                const taskSelect = document.getElementById('task-select');
                
                // Check if task is selected
                if (!taskSelect || !taskSelect.value) {
                    e.preventDefault();
                    alert('❌ Pilih uraian tugas terlebih dahulu!');
                    return false;
                }
                
                // Check if time unit and quantity are filled
                if (!timeUnitHidden.value || !quantityHidden.value) {
                    e.preventDefault();
                    alert('❌ Isi salah satu kolom jenis tugas (Harian/Mingguan/Bulanan/Tahunan)!');
                    return false;
                }
                
                console.log('Form OK - Task:', taskSelect.value, 'Quantity:', quantityHidden.value, 'Unit:', timeUnitHidden.value);
                return true;
            });
        }
    });
</script>

<style>
/* Google-like Searchable Select Styles */
.searchable-select-container {
    position: relative;
    width: 100%;
    overflow: visible; /* Ensure dropdown is not clipped */
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    border: 2px solid #dfe1e5;
    border-radius: 24px;
    background: white;
    transition: all 0.2s ease;
    box-shadow: 0 2px 5px 1px rgba(64,60,67,.16);
}

.search-input-wrapper:hover {
    box-shadow: 0 2px 8px 1px rgba(64,60,67,.24);
}

.search-input-wrapper:focus-within {
    border-color: #4285f4;
    box-shadow: 0 2px 8px 1px rgba(64,60,67,.24);
}

.search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 12px 16px;
    font-size: 16px;
    background: transparent;
    border-radius: 24px;
}

.search-input:focus {
    box-shadow: none;
    border: none;
}

.clear-icon {
    position: absolute;
    right: 16px;
    color: #9aa0a6;
    cursor: pointer;
    padding: 4px;
    border-radius: 50%;
    transition: background-color 0.2s ease;
}

.clear-icon:hover {
    background-color: #f1f3f4;
    color: #5f6368;
}

.search-results {
    position: fixed !important;
    background: white;
    border: 1px solid #dfe1e5;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(32, 33, 36, 0.28);
    z-index: 99999 !important;
    margin-top: 4px;
    max-height: 400px;
    overflow-y: auto;
    width: auto;
    min-width: 200px;
    max-width: 400px; /* Limit maximum width */
}

.search-results-header {
    padding: 8px 16px;
    border-bottom: 1px solid #f1f3f4;
    background: #f8f9fa;
}

.search-results-list {
    max-height: 400px; /* Increased height to show more items */
    overflow-y: auto;
}

.search-result-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f1f3f4;
    transition: background-color 0.2s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 40px; /* Ensure consistent height for better scrolling */
}

.search-result-item.no-results {
    cursor: default;
    background-color: #f8f9fa;
}

.search-result-item.no-results:hover {
    background-color: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.task-description {
    font-size: 14px;
    color: #3c4043;
    font-weight: 400;
    flex: 1;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
    line-height: 1.4;
}

.task-duration {
    font-size: 12px;
    color: #5f6368;
    margin-left: 8px;
}

/* Custom scrollbar for search results */
.search-results-list::-webkit-scrollbar {
    width: 8px;
}

.search-results-list::-webkit-scrollbar-track {
    background: #f1f3f4;
    border-radius: 4px;
}

.search-results-list::-webkit-scrollbar-thumb {
    background: #dadce0;
    border-radius: 4px;
}

.search-results-list::-webkit-scrollbar-thumb:hover {
    background: #bdc1c6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .search-input {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .search-results {
        max-height: 250px;
    }
}

/* Animation for dropdown */
.search-results {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Ensure parent containers don't clip the dropdown */
.card-body {
    overflow: visible !important;
}

.card {
    overflow: visible !important;
}

.row {
    overflow: visible !important;
}

.col-md-6 {
    overflow: visible !important;
}

.container-fluid {
    overflow: visible !important;
}

/* Force dropdown to be above everything with proper sizing */
.search-results {
    position: fixed !important;
    z-index: 99999 !important;
    max-height: 400px !important;
    overflow-y: auto !important;
    max-width: 400px !important;
    min-width: 200px !important;
    word-wrap: break-word !important;
}

/* FORCE PREVIEW BOX TO ALWAYS BE VISIBLE - NEVER HIDE */
#preview-container {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    position: relative !important;
    height: auto !important;
    overflow: visible !important;
}

#preview-box {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>
@endsection
