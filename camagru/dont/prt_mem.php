#include <unistd.h>

void	ft_print_hex(int n)
{
	int c;

	if (n >= 16)
		ft_print_hex(n / 16);
	c = (n % 16) + (((n % 16) < 10) ? '0' : 'a' - 10);
	write(1, &c, 1);
}

void	ft_print_chars(unsigned char c)
{
	(c > 31 && c < 127) ? write(1, &c, 1) : write(1, ".", 1);
}

void	print_memory(const void *addr, size_t size)
{
	unsigned char 	*t = (unsigned char *)addr;
	size_t			i = 0;
	size_t			tmp = 0;
	int				col;
	
	while (i < size)
	{
		col = -1;
		tmp = i;
		while (++col < 16)
		{
			if (i < size)
			{
				if (t[i] < 16)
					write(1, "0", 1);
				ft_print_hex(t[i]);
			}
			else
				write(1, "  ", 2);
			if (i % 2)
				write(1, " ", 1);
			++i;
		}
		col = -1;
		i = tmp;
		while (++col < 16 && i < size)
			ft_print_chars(t[i++]);
		write(1, "\n", 1);
	}
}

void	print_memory(const void *addr, size_t size);

int		main(void)
{
	char		*tab = {0, 23, 150, 255, 12, 16, 21, 42};

	print_memory(tab, sizeof(tab));
	return (0);
}