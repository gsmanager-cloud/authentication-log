<?php


use GSManager\AuthenticationLog\UserActionLog;

if (! function_exists('log_user_action')) {
    function log_user_action(string $action, array $data = [], string $level = 'info'): void
    {
        try {
            UserActionLog::create([
                'user_id'    => auth()->id(),
                'action'     => $action,
                'level'      => $level,
                'data'       => $data,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer'   => request()->headers->get('referer'),
                'url'        => request()->fullUrl(),
            ]);
        } catch (\Throwable $e) {
            logger()->warning("Failed to log user action: {$e->getMessage()}");
        }
    }
}
