<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Application;
use App\Models\MoonshineUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use MoonShine\Decorations\Grid;
use MoonShine\Metrics\DonutChartMetric;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Pages\Page;

class Dashboard extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Аналитика';
    }

    public function components(): array
	{
		return [
            Grid::make([
                ValueMetric::make('Среднее количество заявок на пользователя')
                    ->value(
                        round(intval(MoonshineUser::join('applications', 'moonshine_users.id', '=', 'moonshine_user_id')
                            ->select('moonshine_users.id', 'moonshine_users.name', DB::raw('COUNT(applications.id)'))
                            ->groupBy('moonshine_users.id', 'moonshine_users.name')
                            ->average('applications.id'))),2)
                            ->columnSpan(3),

                ValueMetric::make('Средней бюджет заявок')
                    ->value(round(intval(Application::avg('budget'))). ' ₸')
                    ->columnSpan(3),

                ValueMetric::make('Кол-во заявок от данного пользователя')
                    ->value(
                        Application::query()->where('moonshine_user_id','=',auth()->user()->id)
                        ->count())
                    ->columnSpan(3),
            ]),
            Grid::make([
                DonutChartMetric::make('Общее кол-во заявок')
                    ->values([
                        'Активные' => Application::query()->where('status','Active')->count(),
                        'Купленные у нас' => Application::query()->where('status','By_in_store')->count(),
                        'Купленные в другом месте' => Application::query()->where('status','By_other_store')->count(),
                        'Удаленные' => Application::query()->where('status','Deleted')->count(),
                    ])
                    ->columnSpan(6),
                DonutChartMetric::make('Пользователей')
                    ->values(['Продавцы' => User::query()->count(), 'Пользователи' => MoonshineUser::query()->count()])
                    ->columnSpan(6)
            ]),
            DonutChartMetric::make('Диаграмма бюджета')
                ->values(['до 10000' => Application::query()->where('budget','<=','10000')->count(),
                        'до 15000' => Application::query()->whereBetween('budget',[10001, 15000])->count(),
                        'до 20000' => Application::query()->whereBetween('budget',[15001, 20000])->count(),
                        'до 30000' => Application::query()->whereBetween('budget',[20001, 30000])->count(),
                        'до 40000' => Application::query()->whereBetween('budget',[30001, 40000])->count(),
                        'от 50000' => Application::query()->whereBetween('budget',[40001, 500000])->count(),
                ])
                ->columnSpan(6)
        ];
	}
}
