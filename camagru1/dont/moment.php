/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   moment.c                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: mmbatha <marvin@42.fr>                     +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/08/06 07:52:43 by mmbatha           #+#    #+#             */
/*   Updated: 2018/08/06 08:25:37 by mmbatha          ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include <stdlib.h>

void			ft_strcat(char *str1, char *str, char *str2)
{
	int i;
	int j;

	i = 0;
	while (str[i] != '\0')
	{
		str1[i] = str[i];
		i++;
	}
	j = 0;
	while (str2[j] != '\0')
	{
		str1[i] = str2[j];
		i++;
		j++;
	}
	str1[i] = '\0';
}

int				ft_intlen(int i)
{
	int j;

	j = 0;
	while (i)
	{
		j++;
		i /= 10;
	}
	return (j);
}

char			*ft_itoa(int i)
{
	long	num;
	int		container;
	char	*str;

	num = i;
	container = ft_intlen(i);
	str = (char *)malloc(sizeof(char) * container + 1);
	if (i == 0)
	{
		free(str);
		str = (char *)malloc(sizeof(char) * 2);
		str[0] = '0';
		str[1] = '\0';
		return (str);
	}
	str[container - 1] = '\0';
	container--;
	while(num)
	{
		str[container] = (num % 10 + '0');
		container--;
		num = num / 10;
	}
	return (str);
}

char			*moment(unsigned int duration)
{
	char	*number;
	int		i;
	int		j;
	char	*str;

	j = ft_intlen(duration);
	i = 0;
	if (duration >= 2592000)
	{
		if (duration / 2592000 == 1)
		{
			str = (char *)malloc(sizeof(char) * 13);
			str = "1 month ago.\0";
			return (str);
		}
		else
		{
			number = ft_itoa(duration / 2592000);
			str = (char *)malloc(sizeof(char) * 13 + ft_intlen(duration));
			ft_strcat(str, number, " months ago.\0");
			i += ft_intlen(duration) - 1;
		}
	}
	else if (duration >= 86400)
	{
		if (duration / 86400 == 1)
		{
			str = (char *)malloc(sizeof(char) * 11);
			str = "1 day ago.\0";
			return (str);
		}
		else
		{
			number = ft_itoa(duration / 86400);
			str = (char *)malloc(sizeof(char) * 11 + ft_intlen(duration));
			ft_strcat(str, number, " days ago.\0");
			i += ft_intlen(duration) - 1;
		}
	}
	else if (duration >= 3600)
	{
		if (duration / 3600 == 1)
		{
			str = (char *)malloc(sizeof(char) * 12);
			str = "1 hour ago.\0";
			return (str);
		}
		else
		{
			number = ft_itoa(duration / 3600);
			str = (char *)malloc(sizeof(char) * 12 + ft_intlen(duration));
			ft_strcat(str, number, " hours ago.\0");
			i += ft_intlen(duration) - 1;
		}
	}
	else if (duration >= 60)
	{
		if (duration / 60 == 1)
		{
			str = (char *)malloc(sizeof(char) * 14);
			str = "1 minute ago.\0";
			return (str);
		}
		else
		{
			number = ft_itoa(duration / 60);
			str = (char *)malloc(sizeof(char) * 14 + ft_intlen(duration));
			ft_strcat(str, number, " minutes ago.\0");
			i += ft_intlen(duration) - 1;
		}
	}
	else
	{
		if (duration == 1)
		{
			str = (char *)malloc(sizeof(char) * 14);
			str = "1 second ago.\0";
			return (str);
		}
		else
		{
			number = ft_itoa(duration);
			str = (char *)malloc(sizeof(char) * 14 + ft_intlen(duration));
			ft_strcat(str, number, " seconds ago.\0");
			i += ft_intlen(duration) - 1;
		}
	}
	return (str);
}