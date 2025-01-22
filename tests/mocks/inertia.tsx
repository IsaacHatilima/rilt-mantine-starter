import { vi } from 'vitest';

// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
global.route = vi.fn((name: string, params?: object) => {
    return `/${name}${params ? '?' + new URLSearchParams(params as never) : ''}`;
});
