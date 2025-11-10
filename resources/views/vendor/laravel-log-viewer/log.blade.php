@php use Illuminate\Support\Facades\Crypt; @endphp
        <!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Universitas Nurul Jadid</title>
    <meta name="description"
          content="Sistem kepegawaian Universitas Nurul Jadid - Akses semua layanan digital dengan satu akun">
    <meta name="author" content="Universitas Nurul Jadid">
    <meta name="publisher" content="Pusat Data & Sistem Informasi Universitas Nurul Jadid">
    <meta name="language" content="Indonesian">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noodp, noydir, nocache, notranslate">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet, notranslate">
    <meta name="bingbot" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="slurp" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="duckduckbot" content="noindex, nofollow, noarchive, nosnippet">
    <title>Log Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        surface: '#ffffff',
                        border: '#e2e8f0',
                        error: '#ef4444',
                        warning: '#eab308',
                        info: '#3b82f6',
                        debug: '#64748b',
                        success: '#22c55e',
                    },
                    borderRadius: {
                        xl: '12px'
                    },
                    transitionProperty: {
                        all: 'all'
                    }
                }
            }
        }
    </script>
    <link rel="icon" href="{{ asset('assets/media/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
</head>

<body class="bg-surface dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-all">
<div class="min-h-screen flex flex-col md:flex-row">
    <!-- Sidebar Responsif -->
    <aside
            class="w-full md:w-64 lg:w-72 bg-surface dark:bg-gray-800 border-r border-border dark:border-gray-700 flex flex-col">
        <div class="p-4 border-b border-border dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-2 text-primary font-bold text-lg truncate">
                <i class="fas fa-terminal"></i>
                <span>Log Viewer</span>
            </div>
            <button onclick="toggleTheme()"
                    class="p-2 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                <i class="fas fa-moon hidden dark:inline-block"></i>
                <i class="fas fa-sun dark:hidden"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-2 space-y-1">
            @foreach ($folders as $folder)
                <div class="group relative">
                    <div
                            class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <i class="fas fa-folder text-yellow-500"></i>
                        <span class="text-sm truncate"
                              title="{{ basename($folder) }}">{{ basename($folder) }}</span>
                    </div>
                    @if (count($folder['subfolders']) > 0)
                        <div
                                class="ml-4 hidden group-hover:block absolute left-full top-0 z-10 min-w-[200px] bg-white dark:bg-gray-800 shadow-lg rounded-lg p-2">
                            @foreach ($folder['subfolders'] as $sub)
                                <a href="?l={{ Crypt::encrypt($sub) }}"
                                   class="flex items-center gap-2 p-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg truncate">
                                    <i class="fas fa-folder text-yellow-500"></i>
                                    {{ basename($sub) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            @foreach ($files as $file)
                <a href="?l={{ Crypt::encrypt($file) }}" @class([
                        'flex items-center gap-2 p-2 rounded-lg text-sm truncate transition-colors',
                        'bg-primary text-white hover:bg-primary/90' => $current_file == $file,
                        'hover:bg-gray-100 dark:hover:bg-gray-700' => $current_file != $file,
                    ]) title="{{ $file }}">
                    <i class="fas fa-file-alt"></i>
                    {{ basename($file) }}
                </a>
            @endforeach
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <div
                class="p-4 border-b border-border dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                @if ($current_file)
                    <h1 class="text-xl font-semibold truncate">{{ basename($current_file) }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">{{ count($logs) }} entries
                        found in {{ $current_file }}</p>
                @endif
            </div>
            <div class="flex flex-wrap gap-2">
                @if ($current_file)
                    <div class="flex flex-wrap gap-2">
                        <button onclick="downloadLog()"
                                class="flex items-center gap-2 px-3 py-2 text-sm md:px-4 md:py-2 md:text-base bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-xl hover:border-primary hover:bg-primary/5 transition-all flex-shrink-0">
                            <i class="fas fa-download"></i>
                            <span class="hidden sm:inline">Download</span>
                        </button>
                        <button onclick="cleanLog()"
                                class="flex items-center gap-2 px-3 py-2 text-sm md:px-4 md:py-2 md:text-base bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-xl hover:border-primary hover:bg-primary/5 transition-all flex-shrink-0">
                            <i class="fas fa-sync"></i>
                            <span class="hidden sm:inline">Clean</span>
                        </button>
                        <button onclick="deleteLog()"
                                class="flex items-center gap-2 px-3 py-2 text-sm md:px-4 md:py-2 md:text-base bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-xl hover:border-error hover:bg-error/5 transition-all flex-shrink-0">
                            <i class="fas fa-trash"></i>
                            <span class="hidden sm:inline">Delete</span>
                        </button>
                        @if (count($files) > 1)
                            <button onclick="deleteAllLogs()"
                                    class="flex items-center gap-2 px-3 py-2 text-sm md:px-4 md:py-2 md:text-base bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-xl hover:border-error hover:bg-error/5 transition-all flex-shrink-0">
                                <i class="fas fa-trash-alt"></i>
                                <span class="hidden sm:inline">Delete All</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabel Log -->
        @if ($logs === null)
            <div class="p-4 text-error">
                Log file over 50MB, please
                <a href="?dl={{ Crypt::encrypt($current_file) }}" class="underline">
                    download it
                </a>.
            </div>
        @else
            <div class="flex-1 overflow-auto p-4">
                <div class="min-w-[600px]">
                    <table id="logTable" class="w-full display responsive nowrap">
                        <thead>
                        <tr class="text-left border-b border-border dark:border-gray-700">
                            <th class="pb-3 w-[120px]">Level</th>
                            <th class="pb-3 w-[150px]">Context</th>
                            <th class="pb-3 w-[150px]">Date</th>
                            <th class="pb-3">Content</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-border dark:divide-gray-700">
                        @foreach ($logs as $key => $log)
                            <tr data-stack="stack{{ $key }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="py-3">
                                            <span
                                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $log['level_class'] }}/10 text-{{ $log['level_class'] }} whitespace-nowrap">
                                                {{ $log['level'] }}
                                            </span>
                                </td>
                                <td class="py-3 text-sm truncate" title="{{ $log['context'] }}">
                                    {{ $log['context'] }}</td>
                                <td class="py-3 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $log['date'] }}</td>
                                <td class="py-3">
                                    <div class="flex items-center justify-between">
                                        <pre class="font-mono text-sm whitespace-pre-wrap break-words">{{ $log['text'] }}</pre>
                                        @if ($log['stack'])
                                            <button onclick="toggleStack('stack{{ $key }}')"
                                                    class="text-gray-500 dark:text-gray-400 hover:text-primary ml-2 flex-shrink-0">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @if ($log['stack'])
                                        <div id="stack{{ $key }}"
                                             class="hidden mt-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <pre class="font-mono text-sm whitespace-pre-wrap break-words">{{ trim($log['stack']) }}</pre>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Loading Overlay -->
        <div id="loading"
             class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm flex items-center justify-center hidden transition-opacity">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent"></div>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<script>
    $('#logTable').DataTable({
        responsive: true,
        ordering: false,
        stateSave: true,
        stateDuration: -1,
        columnDefs: [{
            targets: 0,
            className: 'text-center'
        },
            {
                targets: [1, 2],
                responsivePriority: 2
            },
            {
                targets: 3,
                responsivePriority: 1
            }
        ],
        language: {
            search: '_INPUT_',
            searchPlaceholder: 'Search logs...'
        }
    });

    // Manajemen Tema
    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    // Inisialisasi tema awal
    (function initTheme() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.classList.toggle('dark', savedTheme === 'dark');
    })();

    // Fungsi Stack Toggle
    function toggleStack(id) {
        const stack = document.getElementById(id);
        if (!stack) {
            return;
        }
        stack.classList.toggle('hidden');
        const btn = stack.previousElementSibling?.querySelector('button');
        if (btn) {
            btn.querySelector('i').classList.toggle('fa-chevron-down');
            btn.querySelector('i').classList.toggle('fa-chevron-up');
        }
    }

    // Fungsi Aksi File
    const fileActions = {
        showLoading: () => document.getElementById('loading').classList.remove('hidden'),
        hideLoading: () => document.getElementById('loading').classList.add('hidden'),

        downloadLog: () => {
            fileActions.showLoading();
            window.location.href =
                `?dl={{ Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . Crypt::encrypt($current_folder) : '' }}`;
        },

        cleanLog: () => {
            if (confirm('Are you sure you want to clean this log file?')) {
                fileActions.showLoading();
                window.location.href =
                    `?clean={{ Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . Crypt::encrypt($current_folder) : '' }}`;
            }
        },

        deleteLog: () => {
            if (confirm('Are you sure you want to delete this log file?')) {
                fileActions.showLoading();
                window.location.href =
                    `?del={{ Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . Crypt::encrypt($current_folder) : '' }}`;
            }
        },

        deleteAllLogs: () => {
            if (confirm('Are you sure you want to delete ALL log files?')) {
                fileActions.showLoading();
                window.location.href =
                    `?delall=true{{ $current_folder ? '&f=' . Crypt::encrypt($current_folder) : '' }}`;
            }
        }
    };

    // Ekspos fungsi ke global
    window.downloadLog = fileActions.downloadLog;
    window.cleanLog = fileActions.cleanLog;
    window.deleteLog = fileActions.deleteLog;
    window.deleteAllLogs = fileActions.deleteAllLogs;
</script>
</body>

</html>
