void reflection(int arr[19][4],int x, int y, int dir);//dir{1: X axis, 2: Y axis}
void reflect(int arr[19][4],int p, int dir);//dir{1:down 2:up 3:left 4:right} 

//reflection func gets the main data from the user, and decides if the reflect
//should be R/L  or  U/D, then it calls to reflect func, which changes the actual
//point values and creats the reflection.

int  getMiddleX(int arr[19][4]);//retrieve the middle X point of the ship (in order to determine direction)
int  getMiddleY(int arr[19][4]);//retrieve the middle Y point of the ship (in order to determine direction)
int  getRefSide(int p, int mid);//returns 1 for left/down, 2 for right/up

void reflection(int arr[19][4],int x, int y, int dir)
{
	int midX,midY,refSide;

	midX=getMiddleX(arr);
	midY=getMiddleY(arr);
	
	switch (dir)
	{
		case 1:
			{
				refSide=getRefSide(x,midX);
				if (refSide==1)
					reflect(arr, y,  2);
				else
					reflect(arr, y,  1);
				break;
			}
		case 2:
			{
				refSide=getRefSide(y,midY);
				if (refSide==1)
					reflect(arr, x,  3);
				else
					reflect(arr, x,  4);
				break;
			}
	}
}

void reflect(int arr[19][4],int p, int dir)
{
	int i;

	switch (dir)
	{
		case 1:
			{
				for (i=0;i<19;i++)
				{
					arr[i][1]=arr[i][1]-abs((arr[i][1]-p))*2;
					if (arr[i][2]!=-999)
						arr[i][3]=arr[i][3]-abs((arr[i][3]-p))*2;
				}
				break;
			}
		case 2:
			{
				for (i=0;i<19;i++)
				{
					arr[i][1]=arr[i][1]+abs((arr[i][1]-p))*2;
					if (arr[i][2]!=-999)
						arr[i][3]=arr[i][3]+abs((arr[i][3]-p))*2;
				}
				break;
			}
		case 3:
			{
				for (i=0;i<19;i++)
				{
					arr[i][0]=arr[i][0]-abs((arr[i][0]-p))*2;
					if (arr[i][2]!=-999)
						arr[i][2]=arr[i][2]-abs((arr[i][2]-p))*2;
				}
				break;
			}
		case 4:
			{
				for (i=0;i<19;i++)
				{
					arr[i][0]=arr[i][0]+abs((arr[i][0]-p))*2;
					if (arr[i][2]!=-999)
						arr[i][2]=arr[i][2]+abs((arr[i][2]-p))*2;
				}
				break;
			}
	}
}

int  getMiddleX(int arr[19][4])
{
	int min=10000, max=-10000,i ,j;
	for (i=0;i<19;i++)
		for (j=0;j<4;j+=2)
			if (arr[i][j]>max)
				max=arr[i][j];
			if (arr[i][j]<min)
				min=arr[i][j];

	return (min+max)/2;
}
int  getMiddleY(int arr[19][4])
{
	int min=10000, max=-10000,i ,j;
	for (i=0;i<19;i++)
		for (j=1;j<4;j+=2)
			if (arr[i][j]>max)
				max=arr[i][j];
			if (arr[i][j]<min)
				min=arr[i][j];

	return (min+max)/2;
}
int  getRefSide(int p, int mid)
{
	if (p<mid)
		return 1;
	else
		return 2;
}