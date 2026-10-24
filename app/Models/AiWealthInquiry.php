<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiWealthInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'profession',
        'age_group',
        'challenge',
        'current_income',
        'page',
        'source',
        'status',
        'ip_address',
    ];

    public static function professionLabels(): array
    {
        return [
            'student' => 'Student / Fresher',
            'job' => 'Job / Employee',
            'freelancer' => 'Freelancer',
            'business' => 'Business Owner',
            'coach' => 'Coach / Consultant',
            'other' => 'Other',
        ];
    }

    public static function challengeLabels(): array
    {
        return [
            'leads' => 'Leads are not coming',
            'sales' => 'Sales are not closing',
            'content' => 'Content / marketing confusion',
            'automation' => 'No business automation',
            'ai' => "Don't know how to use AI",
            'mindset' => 'Mindset / consistency',
            'other' => 'Other',
        ];
    }

    public static function pageLabels(): array
    {
        return [
            'ai-wealth-business' => 'Accelerator-old',
            'ai-wealth-business-growth-accelerator' => 'Accelerator-old',
            'ai-wealth-business-growth-accelerator-1' => 'Accelerator',
            'ai-business-growth-accelerator' => 'AI Business Growth',
            'meta-ads' => 'Meta Ads',
        ];
    }

    public static function pageFilterOptions(): array
    {
        return [
            'ai-wealth-business-growth-accelerator-1' => 'Accelerator',
            'ai-wealth-business-growth-accelerator' => 'Accelerator-old',
            'ai-business-growth-accelerator' => 'AI Business Growth',
            'meta-ads' => 'Meta Ads',
        ];
    }

    public function getPageLabelAttribute(): string
    {
        return self::pageLabels()[$this->page] ?? ($this->page ?: 'N/A');
    }

    public static function incomeLabels(): array
    {
        return [
            'not-earning' => 'Not Earning Yet',
            '10-20k' => '₹10K – ₹20K',
            '20-30k' => '₹20K – ₹30K',
            '30-50k' => '₹30K – ₹50K',
            '50-70k' => '₹50K – ₹70K',
            '70k-1l' => '₹70K – ₹1 Lakh',
            '1l-1.5l' => '₹1 Lakh – ₹1.5 Lakh',
            '1.5l-plus' => '₹1.5 Lakh +',
        ];
    }

    public function getProfessionLabelAttribute(): string
    {
        return self::professionLabels()[$this->profession] ?? ($this->profession ?: 'N/A');
    }

    public function getChallengeLabelAttribute(): string
    {
        return self::challengeLabels()[$this->challenge] ?? ($this->challenge ?: 'N/A');
    }

    public function getIncomeLabelAttribute(): string
    {
        return self::incomeLabels()[$this->current_income] ?? ($this->current_income ?: 'N/A');
    }
}
