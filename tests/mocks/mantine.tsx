import { vi } from 'vitest';

vi.mock('@mantine/hooks', () => ({
    useDisclosure: () => [false, { open: vi.fn(), close: vi.fn() }],
}));

vi.mock('@mantine/core', () => ({
    Button: ({ children, ...props }: any) => (
        <button {...props}>{children}</button>
    ),
    TextInput: (props: any) => <input {...props} />,
    PasswordInput: (props: any) => <input type="password" {...props} />,
    Checkbox: (props: any) => <input type="checkbox" {...props} />,
    Alert: ({ children }: any) => <div>{children}</div>,
    Divider: () => <hr />,
    Card: ({ children, ...props }: any) => <div {...props}>{children}</div>,
}));
