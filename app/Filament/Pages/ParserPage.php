<?php

namespace App\Filament\Pages;

use App\Jobs\Import\DiscoverUrlsJob;
use App\Models\ImportRun;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ParserPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Парсер';

    protected static ?string $navigationLabel = 'Запустить парсер';

    protected static ?string $title = 'Парсер svoymaster96.ru';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.parser-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'seed_url' => 'https://www.svoymaster96.ru/',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('seed_url')
                    ->label('Seed URL (стартовая страница)')
                    ->placeholder('https://www.svoymaster96.ru/')
                    ->url()
                    ->required()
                    ->default('https://www.svoymaster96.ru/')
                    ->helperText(
                        'Укажите главную страницу сайта — парсер обойдёт все бренды автоматически. ' .
                        'Или конкретную страницу, например https://www.svoymaster96.ru/apple-iphone'
                    )
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ImportRun::query()->latest())
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->width(60),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'running' => 'warning',
                        'success' => 'success',
                        'failed'  => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'running' => 'Выполняется',
                        'success' => 'Успешно',
                        'failed'  => 'Ошибка',
                        default   => $state,
                    }),

                TextColumn::make('seed_url')
                    ->label('URL')
                    ->limit(45),

                TextColumn::make('initiated_by')
                    ->label('Кто запустил')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('started_at')
                    ->label('Запущен')
                    ->dateTime('d.m.Y H:i'),

                TextColumn::make('stats_json.urls_discovered')
                    ->label('URL')
                    ->default(0)
                    ->alignCenter(),

                TextColumn::make('stats_json.items_extracted')
                    ->label('Записей')
                    ->default(0)
                    ->alignCenter(),

                TextColumn::make('stats_json.new')
                    ->label('Новых')
                    ->default(0)
                    ->color('success')
                    ->alignCenter(),

                TextColumn::make('stats_json.errors')
                    ->label('Ошибок')
                    ->default(0)
                    ->color('danger')
                    ->alignCenter(),

                TextColumn::make('finished_at')
                    ->label('Завершён')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('Идёт…'),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10])
            ->poll('5s');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('run_parser')
                ->label('Запустить парсер')
                ->icon('heroicon-o-play')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Запустить парсинг?')
                ->modalDescription(
                    fn () => 'Будет запущен обход сайта: ' . ($this->data['seed_url'] ?? 'не указан') .
                        '. Это займёт несколько минут.'
                )
                ->modalSubmitActionLabel('Запустить')
                ->action(function (): void {
                    $this->form->validate();

                    $seedUrl = $this->data['seed_url'];
                    $initiatedBy = Auth::user()?->email ?? 'admin';

                    DiscoverUrlsJob::dispatch($seedUrl, $initiatedBy)
                        ->onQueue('parser');

                    Notification::make()
                        ->title('Парсер запущен!')
                        ->body("Обход сайта {$seedUrl} добавлен в очередь. Следите за прогрессом в таблице ниже.")
                        ->success()
                        ->duration(6000)
                        ->send();
                }),
        ];
    }
}
